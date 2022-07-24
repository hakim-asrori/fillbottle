@extends('layouts.admin')

@section('main-content')
@php
$branch_id = $bid;
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col col-lg-8 col-md-8 mb-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Item</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>KATE-1</td>
                                    <td>Baju Anak</td>
                                    <td class="text-right">15.000</td>
                                    <td class="text-right">2</td>
                                    <td class="text-right">30.000</td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <b>Total</b>
                                    </td>
                                    <td class="text-right">
                                        <b>150.000</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('transaction.index') }}" class="btn btn-sm btn-danger">Tutup</a>
                </div>
            </div>
        </div>
        <div class="col col-lg-4 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ringkasan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Nama Pemesan</td>
                                    <td>Hanya Contoh</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pemesanan</td>
                                    <td>01 Januari 2022</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>100.000</td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td>COD</td>
                                </tr>
                                <tr>
                                    <td>Status Pemesanan</td>
                                    <td>Proses</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection