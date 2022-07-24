<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\stockRequest;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->data['bname'] = null;
        $this->data['bid'] = null;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->query('id');
        if (Auth::user()->level == 0) {
            $transactions = Transaction::where("branch_id", "=", $id)->orderBy('id', 'ASC');
            $branch = Branch::where("id", '=', $id)->value('nama');
            $bid = $id;
        } else {
            $bid = User::join('user_branches', 'user_branches.user_id', 'users.id')->where('users.id', $id)->value('user_branches.branch_id');
            $transactions = Transaction::where("branch_id", "=", $bid)->orderBy('id', 'ASC');
            $branch = Branch::where("id", '=', $bid)->value('nama');
        }

        $this->data['bname'] = $branch;
        $this->data['bid'] = $bid;
        $this->data['transactions'] = $transactions->paginate(10);
        return view('admin.transaction.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.transaction.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StockRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
