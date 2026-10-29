<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\UserProfileModel;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Models\UserIdentityModel;

class Profile extends BaseController
{
    public function index(): string
    {
        $user = auth()->user();
        $profileModel = new UserProfileModel();
        $transactionModel = new TransactionModel();

        $profile = $profileModel
            ->where('user_id', $user->id)
            ->first();

        $income = (clone $transactionModel)
            ->where('user_id', $user->id)
            ->where('type', 'income')
            ->selectSum('amount')
            ->first();

        $expense = (clone $transactionModel)
            ->where('user_id', $user->id)
            ->where('type', 'expense')
            ->selectSum('amount')
            ->first();

        $totalTransactions = (clone $transactionModel)
            ->where('user_id', $user->id)
            ->countAllResults();

        $expenseByCategory = (clone $transactionModel)
            ->select('category, SUM(amount) AS total', false)
            ->where('user_id', $user->id)
            ->where('type', 'expense')
            ->groupBy('category')
            ->orderBy('total', 'DESC')
            ->findAll();

        return view('profile/index', [
            'username' => $user->username ?? 'Pengguna',
            'email' => $user->email ?? '',
            'photoPath' => $profile['photo_path'] ?? null,
            'totalIncome' => (float) ($income['amount'] ?? 0),
            'totalExpense' => (float) ($expense['amount'] ?? 0),
            'totalTransactions' => $totalTransactions,
            'expenseByCategory' => $expenseByCategory,
        ]);
    }

    public function updateProfile()
    {
        $user = auth()->user();
        $username = trim((string) $this->request->getPost('username'));
        $email = trim((string) $this->request->getPost('email'));
        $identity = $user->getEmailIdentity();

        $usernameRules = config('Auth')->usernameValidationRules;
        $usernameRules['rules'] = (array) $usernameRules['rules'];
        $usernameRules['rules'][] = sprintf(
            'is_unique[%s.username,id,%s]',
            config('Auth')->tables['users'],
            $user->id,
        );

        $emailRules = config('Auth')->emailValidationRules;
        $emailRules['rules'] = (array) $emailRules['rules'];
        $uniqueEmailRule = sprintf(
            'is_unique[%s.secret',
            config('Auth')->tables['identities'],
        );
        if ($identity !== null) {
            $uniqueEmailRule .= sprintf(',id,%s', $identity->id);
        }
        $emailRules['rules'][] = $uniqueEmailRule . ']';

        if (! $this->validateData(
            ['username' => $username, 'email' => $email],
            ['username' => $usernameRules, 'email' => $emailRules],
            [],
            config('Auth')->DBGroup,
        )) {
            return redirect()->to(site_url('dashboard/profile'))
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('showProfileModal', true);
        }

        $database = \Config\Database::connect(config('Auth')->DBGroup);
        $database->transBegin();

        try {
            if ($username !== $user->username) {
                $user->username = $username;
                $userModel = model(UserModel::class);

                if (! $userModel->save($user)) {
                    $database->transRollback();

                    return redirect()->to(site_url('dashboard/profile'))
                        ->withInput()
                        ->with('errors', $userModel->errors())
                        ->with('showProfileModal', true);
                }
            }

            if ($identity === null) {
                $user->createEmailIdentity([
                    'email' => $email,
                    'password' => '',
                ]);
            } elseif ($email !== $identity->secret) {
                $identity->secret = $email;
                $identityModel = model(UserIdentityModel::class);

                if (! $identityModel->save($identity)) {
                    $database->transRollback();

                    return redirect()->to(site_url('dashboard/profile'))
                        ->withInput()
                        ->with('errors', $identityModel->errors())
                        ->with('showProfileModal', true);
                }
            }
        } catch (ValidationException) {
            $database->transRollback();

            return redirect()->to(site_url('dashboard/profile'))
                ->withInput()
                ->with('error', 'Username atau email gagal diperbarui.')
                ->with('showProfileModal', true);
        }

        $database->transCommit();

        return redirect()->to(site_url('dashboard/profile'))
            ->with('message', 'Username dan email berhasil diperbarui.');
    }

    public function updatePhoto()
    {
        if (! $this->validate([
            'photo' => [
                'label' => 'Foto profil',
                'rules' => [
                    'uploaded[photo]',
                    'is_image[photo]',
                    'mime_in[photo,image/jpeg,image/png,image/webp]',
                    'max_size[photo,2048]',
                ],
            ],
        ])) {
            return redirect()->to(site_url('dashboard/profile'))
                ->with('errors', $this->validator->getErrors());
        }

        $photo = $this->request->getFile('photo');
        $uploadDirectory = FCPATH . 'uploads/profiles';

        if (! is_dir($uploadDirectory) && ! mkdir($uploadDirectory, 0755, true) && ! is_dir($uploadDirectory)) {
            return redirect()->to(site_url('dashboard/profile'))
                ->with('error', 'Folder penyimpanan foto tidak dapat dibuat.');
        }

        $fileName = $photo->getRandomName();

        try {
            $photo->move($uploadDirectory, $fileName);
        } catch (\Throwable) {
            return redirect()->to(site_url('dashboard/profile'))
                ->with('error', 'Foto profil gagal diunggah.');
        }

        $photoPath = 'uploads/profiles/' . $fileName;
        $profileModel = new UserProfileModel();
        $userId = auth()->user()->id;
        $existingProfile = $profileModel
            ->where('user_id', $userId)
            ->first();

        if ($existingProfile) {
            $saved = $profileModel->update($existingProfile['id'], [
                'photo_path' => $photoPath,
            ]);
        } else {
            $saved = $profileModel->insert([
                'user_id' => $userId,
                'photo_path' => $photoPath,
            ]);
        }

        if (! $saved) {
            unlink($uploadDirectory . DIRECTORY_SEPARATOR . $fileName);

            return redirect()->to(site_url('dashboard/profile'))
                ->with('error', 'Foto profil gagal disimpan.');
        }

        if ($existingProfile && str_starts_with($existingProfile['photo_path'] ?? '', 'uploads/profiles/')) {
            $oldPhoto = $uploadDirectory . DIRECTORY_SEPARATOR . basename($existingProfile['photo_path']);

            if (is_file($oldPhoto)) {
                unlink($oldPhoto);
            }
        }

        return redirect()->to(site_url('dashboard/profile'))
            ->with('message', 'Foto profil berhasil diperbarui.');
    }

    public function deletePhoto()
    {
        $userId = auth()->user()->id;
        $profileModel = new UserProfileModel();
        $profile = $profileModel
            ->where('user_id', $userId)
            ->first();

        if (! $profile || empty($profile['photo_path'])) {
            return redirect()->to(site_url('dashboard/profile'))
                ->with('error', 'Belum ada foto profil untuk dihapus.');
        }

        if (! $profileModel->delete($profile['id'])) {
            return redirect()->to(site_url('dashboard/profile'))
                ->with('error', 'Foto profil gagal dihapus.');
        }

        if (str_starts_with($profile['photo_path'], 'uploads/profiles/')) {
            $photoFile = FCPATH . 'uploads/profiles' . DIRECTORY_SEPARATOR
                . basename($profile['photo_path']);

            if (is_file($photoFile)) {
                unlink($photoFile);
            }
        }

        return redirect()->to(site_url('dashboard/profile'))
            ->with('message', 'Foto profil berhasil dihapus.');
    }
}
