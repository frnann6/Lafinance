<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $user = auth()->user();
        $transactionModel = new \App\Models\TransactionModel();

        $userId = $user->id;

        $totalPemasukan = (clone $transactionModel)
            ->where('user_id', $userId)
            ->where('type', 'income')
            ->selectSum('amount')
            ->first();

        $totalPengeluaran = (clone $transactionModel)
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->selectSum('amount')
            ->first();

        $pemasukan = (float) ($totalPemasukan['amount'] ?? 0);
        $pengeluaran = (float) ($totalPengeluaran['amount'] ?? 0);

        $transaksiTerbaru = $transactionModel
            ->where('user_id', $userId)
            ->orderBy('transaction_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll(5);

        $transactions = (new TransactionModel())
            ->where('user_id', $user->id)
            ->orderBy('transaction_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll(3);

        return view('dashboard', [
            'activeMenu'       => 'home',
            'totalPemasukan'   => $pemasukan,
            'totalPengeluaran' => $pengeluaran,
            'totalSaldo'       => $pemasukan - $pengeluaran,
            'transaksiTerbaru' => $transaksiTerbaru,
            'transactions' => $transactions,
            ]);
    }
}
