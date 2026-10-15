<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;

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

        return view('transactions/index', [
            'transactions' => $transactions,
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

        return redirect()->to(site_url('transactions'))
            ->with('message', 'Transaksi berhasil disimpan.');
    }
}
