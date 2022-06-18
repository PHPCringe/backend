<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionDonationController extends Controller
{
    public function store(Request $request)
    {
        $createdTransaction = Transaction::create([
            'from_user_id' => $request->from_user_id,
            'to_user_id' => $request->to_user_id,
            'type' => $request->type,
            'issued_by' => 0, // Since this is a donation, issued_by is always 0
            'currency_id' => $request->currency_id,
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        return $this->responseJson(201, 'Successfully saved donation transaction', $createdTransaction);
    }

    public function show(Request $request, string $donationID)
    {
        $validator = Validator::make($request->all(), [
            'donation_id' => 'required|exists:transactions,id'
        ]);
        if ($validator->fails()) {
            return $this->responseJson(422, "Error", $validator->errors());
        }

        $transaction = Transaction::find($donationID);

        if (!$transaction) {
            return $this->responseJson(404, 'Transaction not found');
        }

        return $this->responseJson(200, 'Transaction found', $transaction);
    }
}
