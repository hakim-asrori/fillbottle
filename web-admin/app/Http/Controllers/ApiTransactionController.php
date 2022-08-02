<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\DetailTransactions;
use App\Models\Keranjang;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class ApiTransactionController extends Controller
{
    public function showTransaction($id): JsonResponse
    {
        $sql = Transaction::where('user_id', $id)->get();
        return response()->json($sql);
    }

    public function showDetailTransaction($id): JsonResponse
    {
        $sql = DetailTransactions::where('transaction_id', $id)->get();
        return response()->json($sql);
    }
    public function saveTransaction(Request $request)
    {
        $params = $request->except('_token');
        $saved = false;
        $saved = DB::transaction(function () use ($params) {
            $transaction = Transaction::create($params);
            $transaction->detail()->sync($params['transaction_id']);
            $details = [
                'name' => $params['nama'],
                'email' => null,
                'subject' => "Permintaan Transaksi",
                'msg' => $params['nama'].'telah melakukan pembelian',
            ];
    
            Mail::to('fillbottleproject@gmail.com')->send(new ContactMail($details));
            return true;
        });
        if ($saved) {
            $sql = "Berhasil";
        } else {
            $sql = "Gagal";
        }
        return response()->json($sql);
    }
}
