<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\transactionResource;
use App\Models\transactions as ModelsTransactions;


class transactions extends Controller
{
    public function index()
    {
        $transactions = (new ModelsTransactions)->allTransaction();

        return response()->json(['data' => $transactions]);
    }

    public function searchTransaction(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $transactions = (new ModelsTransactions)->search($searchTerm);

        return response()->json(['data' => $transactions]);
    }

    public function DataTransaction()
    {
        return view('transaction');
    }

    public function store(Request $request)
    {
        if ($request->input('id') == null) {
            $transaction = ModelsTransactions::create($request->all());
        } else {
            $transaction = ModelsTransactions::findOrFail($request->input('id'));
            $transaction->update($request->all());
        }


        if ($transaction) {
            $transactions = (new ModelsTransactions)->allTransaction();
            return response()->json(['data' => $transactions]);
        } else {
            return response()->json(['error' => 'Gagal membuat entri transaksi'], 500);
        }
    }

    public function deleted(Request $request)
    {

        $request->input('id');
        $transaction = ModelsTransactions::findOrFail($request->input('id'));
        $transaction->delete($request->all());



        if ($transaction) {
            $transactions = (new ModelsTransactions)->allTransaction();
            return response()->json(['data' => $transactions]);
        } else {
            return response()->json(['error' => 'Gagal membuat entri transaksi'], 500);
        }
    }

    public function filter(Request $request)
    {
        $filter = $request->input('filter');
        $start = $request->input('startDate');
        $end = $request->input('endDate');
        if ($filter == 1) {
            $transactions = (new ModelsTransactions)->filterUp($start, $end);
        } else {
            $transactions = (new ModelsTransactions)->filterDown($start, $end);
        }

        return response()->json(['data' => $transactions]);
    }
}
