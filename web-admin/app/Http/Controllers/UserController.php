<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Branch;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->data['levels'] = User::levels();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('level', '0')->orWhere('level', '1')->orderBy('name', 'ASC');
        $this->data['users'] = $users->paginate(10);
        return view('admin.user.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::orderBy('nama', 'ASC')->get();
        $this->data['branches'] = $branches->toArray();
        $this->data['branchID'] = null;

        $this->data['user'] = null;
        return view('admin.user.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $params = $request->except('_token');
        $params['password'] = Hash::make($request->password);
        $saved = false;
        if ($request->input('level') == 1) {
            $request->validate([
                'branch_id' => 'required',
            ]);
            $saved = DB::transaction(function () use ($params) {
                $user = User::create($params);
                $user->branches()->sync($params['branch_id']);
                return true;
            });
        } else {
            $saved = DB::transaction(function () use ($params) {
                $user = User::create($params);
                return true;
            });
        }


        if ($saved) {
            Session::flash('success', 'User has been saved');
        } else {
            Session::flash('error', 'User could not be saved');
        }
        return redirect('admin/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $branch = $user->join('user_branches', 'user_branches.user_id', '=', 'users.id')->where('users.id', $id)->value('branch_id');
        $this->data['user'] = $user;

        $branches = Branch::orderBy('nama', 'ASC')->get();

        $this->data['branches'] = $branches->toArray();
        $this->data['branchID'] = $branch;
        return view('admin.user.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $params = $request->except('_token');

        if ($request->filled('password')) {
            $params['password'] = Hash::make($request->password);
        } else {
            $params = $request->except('password');
        }
        $user = User::findOrFail($id);
        $saved = false;
        if ($request->input('level') == 1) {
            $request->validate([
                'branch_id' => 'required',
            ]);
            $saved = DB::transaction(function () use ($user, $params) {
                $user->update($params);
                $user->branches()->sync($params['branch_id']);
                return true;
            });
        } else {
            $saved = DB::transaction(function () use ($user, $params) {
                $user->update($params);
                return true;
            });
        }





        if ($saved) {
            Session::flash('success', 'User has been update');
        } else {
            Session::flash('error', 'User could not be saved');
        }
        return redirect('admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->delete()) {
            Session::flash('success', 'User has been delete');
        }
        return redirect('admin/user');
    }
}
