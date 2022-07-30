<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiKeranjangController extends Controller
{
    public function showKeranjang($id): JsonResponse
    {
        $sql = Keranjang::join('users','users.id','keranjangs.user_id')
        ->join('products','products.id','keranjangs.product_id')
        ->where('users.id',$id)->get();
        return response()->json($sql);
    }

    public function simpanKeranjang(Request $request): JsonResponse
    {
        $params = $request->except('_token');

        $saved = false;
        $saved = DB::transaction(function () use ($params) {
            $sql = Keranjang::create($params);
            return true;
        });

        if ($saved) {
            $sql = 'Berhasil';
        } else {
            $sql = 'Gagal';
        }
        return response()->json($sql);
    }

    public function tambahJumlah($id): JsonResponse
    {
        $sql = Keranjang::findOrFail($id);
        if($sql->update(['jumlah' => $sql->jumlah + 1])){
            $pesan = "Berhasil";
        }
        return response()->json($pesan);
    }

    public function kurangJumlah($id): JsonResponse
    {
        $sql = Keranjang::findOrFail($id);
        if($sql->update(['jumlah' => $sql->jumlah - 1])){
            $pesan = "Berhasil";
        }
        return response()->json($pesan);
    }

    public function deleteKeranjang($id): JsonResponse
    {
        $sql = Keranjang::findOrFail($id);
        if($sql->delete()){
            $pesan = "Berhasil";
        }
        return response()->json($pesan);
    }
}
