<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\UserProfileModel;

class Transactions extends BaseController
{
    public function index()
    {
        $user = auth()->user();

        $transactionModel = new TransactionModel();

        $transactions = $transactionModel
            ->where('user_id', $user->id)
            ->orderBy('transaction_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll();

        $profile = (new UserProfileModel())
            ->where('user_id', $user->id)
            ->first();

        return view('transactions/index', [
            'transactions' => $transactions,
            'displayName'  => $user->username ?? 'Pengguna',
            'photoPath'    => $profile['photo_path'] ?? null,
        ]);
    }


    public function create(): string
    {
        return view('transactions/create');
    }

    public function store()
    {
        $user = auth()->user();

        $transactionModel = new \App\Models\TransactionModel();

        $data = [
            'user_id'          => $user->id,
            'type'             => $this->request->getPost('type'),
            'category'         => trim((string) $this->request->getPost('category')),
            'amount'           => $this->request->getPost('amount'),
            'description'      => trim((string) $this->request->getPost('description')),
            'transaction_date' => $this->request->getPost('transaction_date'),
        ];

        // Validasi saldo sebelum menyimpan pengeluaran
        if ($data['type'] === 'expense') {
            $totalPemasukan = (clone $transactionModel)
                ->where('user_id', $user->id)
                ->where('type', 'income')
                ->selectSum('amount')
                ->first();

            $totalPengeluaran = (clone $transactionModel)
                ->where('user_id', $user->id)
                ->where('type', 'expense')
                ->selectSum('amount')
                ->first();

            $saldo = (float) ($totalPemasukan['amount'] ?? 0)
                - (float) ($totalPengeluaran['amount'] ?? 0);

            $nominalExpense = (float) $data['amount'];

            if ($saldo <= 0 || $nominalExpense > $saldo) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', $saldo <= 0
                        ? 'Saldo kamu Rp0. Catat pemasukan terlebih dahulu sebelum menambah pengeluaran.'
                        : 'Saldo kamu tidak mencukupi untuk pengeluaran ini.');
            }
        }

        if (! $transactionModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $transactionModel->errors());
        }

        return redirect()->to(site_url('dashboard/transactions'))
            ->with('message', 'Transaksi berhasil disimpan.');
    }

    public function update($id)
    {
        $user = auth()->user();
        $transactionModel = new TransactionModel();

        // Pastikan transaksi milik user yang login.
        $transaction = $transactionModel
            ->where('user_id', $user->id)
            ->find($id);

        if (! $transaction) {
            return redirect()->to(site_url('dashboard/transactions'))
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        $data = [
            'type'             => $this->request->getPost('type'),
            'category'         => trim((string) $this->request->getPost('category')),
            'amount'           => $this->request->getPost('amount'),
            'transaction_date' => $this->request->getPost('transaction_date'),
            'description'      => trim((string) $this->request->getPost('description')),
        ];

        $rules = [
            'type'             => 'required|in_list[income,expense]',
            'category'         => 'required|max_length[100]',
            'amount'           => 'required|numeric|greater_than[0]',
            'transaction_date' => 'required|valid_date[Y-m-d]',
            'description'      => 'permit_empty|max_length[1000]',
        ];

        if (! $this->validateData($data, $rules)) {
            return redirect()->to(site_url('dashboard/transactions'))
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Periksa kembali data transaksi.');
        }

        // Jika menjadi pengeluaran, hitung saldo tanpa transaksi yang sedang diedit.
        if ($data['type'] === 'expense') {
            $totalPemasukan = (clone $transactionModel)
                ->where('user_id', $user->id)
                ->where('type', 'income')
                ->where('id !=', $id)
                ->selectSum('amount')
                ->first();

            $totalPengeluaran = (clone $transactionModel)
                ->where('user_id', $user->id)
                ->where('type', 'expense')
                ->where('id !=', $id)
                ->selectSum('amount')
                ->first();

            $saldo = (float) ($totalPemasukan['amount'] ?? 0)
                - (float) ($totalPengeluaran['amount'] ?? 0);

            if ($saldo <= 0 || (float) $data['amount'] > $saldo) {
                return redirect()->to(site_url('dashboard/transactions'))
                    ->with('error', $saldo <= 0
                        ? 'Transaksi tidak dapat diperbarui karena saldo tidak mencukupi untuk pengeluaran ini.'
                        : 'Saldo kamu tidak mencukupi untuk pengeluaran ini.');
            }
        }

        if (! $transactionModel->update($id, $data)) {
            return redirect()->to(site_url('dashboard/transactions'))
                ->with('errors', $transactionModel->errors())
                ->with('error', 'Transaksi gagal diperbarui.');
        }

        return redirect()->to(site_url('dashboard/transactions'))
            ->with('message', 'Transaksi berhasil diperbarui.');
    }

    public function delete($id)
    {
        $user = auth()->user();
        $transactionModel = new \App\Models\TransactionModel();

        // Jangan izinkan user menghapus transaksi milik user lain.
        $transaction = $transactionModel
            ->where('user_id', $user->id)
            ->find($id);

        if (! $transaction) {
            return redirect()->to(site_url('dashboard/transactions'))
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        if (! $transactionModel->delete($id)) {
            return redirect()->to(site_url('dashboard/transactions'))
                ->with('error', 'Transaksi gagal dihapus.');
        }

        return redirect()->to(site_url('dashboard/transactions'))
            ->with('message', 'Transaksi berhasil dihapus.');
    }
}
