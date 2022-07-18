<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Branch;
use App\Models\Customer;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Nette\Utils\DateTime;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = customer::select(DB::raw('customers.*,users.name,users.last_name,users.email'))
            ->join('users', 'users.id', 'customers.user_id')->where('users.level', '3')->orderBy('users.name', 'ASC');
        $this->data['customers'] = $customers->paginate(10);
        return view('admin.customer.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['user'] = null;
        return view('admin.customer.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(customerRequest $request)
    {
        $params = $request->except('_token');
        $params['password'] = Hash::make($request->password);
        $params['level'] = '3';

        if ($request->has('foto')) {
            $params['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['name']);
        }

        $saved = false;
        $saved = DB::transaction(function () use ($params) {
            $user = User::create($params);
            $params['user_id'] = $user->id;
            Customer::create($params);
            return true;
        });

        if ($saved) {
            Session::flash('success', 'Customer has been saved');
        } else {
            Session::flash('error', 'Customer could not be saved');
        }
        return redirect('admin/customer');
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
        $customer = customer::select(DB::raw('customers.*,users.name,users.last_name,users.email'))
            ->join('users', 'users.id', 'customers.user_id')->where('customers.id', $id)->first();
        $this->data['customer'] = $customer;
        return view('admin.customer.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(customerRequest $request, $id)
    {
        $foto = false;
        $pass = false;

        $customer = Customer::findOrFail($id);
        $params = $request->except('_token');

        $k = array('_token', 'alamat', 'kota', 'provinsi', 'kodepos', 'telp', 'foto');
        $u = array('_token', 'name', 'last_name', 'email', 'level', 'branch_id', 'password');

        if ($request->filled('password')) {
            $pass = true;
        } else {
            array_push($k, 'password');
        }
        if ($request->has('foto')) {
            $foto = true;
        } else {
            array_push($u, 'foto');
        }

        $params = $request->except($k);
        $params2 = $request->except($u);

        if ($pass) {
            $params['password'] = Hash::make($request->password);
        }
        if ($foto) {
            $params2['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['name']);
        }

        $params['level'] = '3';

        $saved = false;
        $saved = DB::transaction(function () use ($customer, $params, $params2) {
            $customer->update($params2);
            $user = User::findOrFail($customer->user_id);
            $user->update($params);
            return true;
        });

        if ($saved) {
            Session::flash('success', 'customer has been saved');
        } else {
            Session::flash('error', 'customer could not be saved');
        }
        return redirect('admin/customer');
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
            Session::flash('success', 'customer has been delete');
        }
        return redirect('admin/customer');
    }

    private function simpanImage($type, $foto, $nama)
    {
        $dt = new DateTime();

        $path = public_path('uploads/customer/' . $dt->format('Y-m-d') . '/' . $nama);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $file = $foto;
        $name =  $type . '_' . time();
        $fileName = $name . '.' . $file->getClientOriginalExtension();
        $folder = '/uploads/customer/' . $dt->format('Y-m-d') . '/' . $nama;
        $filePath = $file->storeAs($folder, $fileName, 'public');
        return $filePath;
    }
}
