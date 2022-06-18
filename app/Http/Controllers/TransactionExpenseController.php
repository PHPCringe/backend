<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionExpenseController extends Controller
{
    public function store(Request $request)
    {
        $createdTransaction = Transaction::create([
            'from_user_id' => $request['from_user_id'],
            'to_user_id' => $request['to_user_id'],
            'type' => $request['type'],
            'issued_by' => $request['issued_by'],
            'currency_id' => $request['currency_id'],
            'title' => $request['title'],
            'description' => $request['description'],
            'amount' => $request['amount'],
        ]);

        return $this->responseJson(201, 'Successfully saved expense transction', $createdTransaction);
    }

    public function show(Request $request, string $expenseID)
    {
        $transaction = Transaction::find($expenseID);
        return $this->responseJson(200, 'Transaction found', $transaction);
    }
}
