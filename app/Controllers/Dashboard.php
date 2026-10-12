<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $user = auth()->user();

        $transactions = (new TransactionModel())
            ->where('user_id', $user->id)
            ->orderBy('transaction_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll(3);

        return view('dashboard', ['transactions' => $transactions]);
    }
}
