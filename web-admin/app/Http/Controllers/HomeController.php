<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $level = Auth::user()->level;
        $userid = Auth::user()->id;
        if ($level == 0) {
            $nama = "Admin";
        } elseif ($level == 1) {
            $branch = Branch::join('user_branches', 'user_branches.branch_id', 'branches.id')->where('user_branches.user_id', $userid)->value('branches.nama');
            $nama = $branch;
        }
        $this->data['users'] = $users;
        $this->data['nama'] = $nama;
        return view('home', $this->data);
    }

    public function notAdmin()
    {
        return view('notAdmin');
    }
}
