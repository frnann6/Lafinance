<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'user_id',
        'type',
        'category',
        'amount',
        'description',
        'transaction_date',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'type' => 'required|in_list[income,expense]',
        'category' => 'required|max_length[100]',
        'amount' => 'required|decimal|greater_than[0]',
        'transaction_date' => 'required|valid_date[Y-m-d]',
    ];

    protected $validationMessages = [
        'type' => [
            'in_list' => 'Jenis transaksi harus pemasukan atau pengeluaran.',
        ],
        'amount' => [
            'greater_than' => 'Nominal transaksi harus lebih dari nol.',
        ],
    ];
}