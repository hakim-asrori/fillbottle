<?php

namespace App\Http\Controllers;

use App\Http\Requests\KurirRequest;
use App\Models\Branch;
use App\Models\Kurir;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Nette\Utils\DateTime;

class KurirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kurirs = Kurir::select(DB::raw('kurirs.*,users.name,users.last_name,users.email'))
            ->join('users', 'users.id', 'kurirs.user_id')->where('users.level', '2')->orderBy('users.name', 'ASC');
        $this->data['kurirs'] = $kurirs->paginate(10);
        return view('admin.kurir.index', $this->data);
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
        return view('admin.kurir.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KurirRequest $request)
    {
        $params = $request->except('_token');
        $params['password'] = Hash::make($request->password);
        $params['level'] = '2';

        if ($request->has('foto')) {
            $params['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['name']);
        }
        if ($request->has('ktp')) {
            $params['ktp'] = $this->simpanImage('ktp', $request->file('ktp'), $params['name']);
        }
        if ($request->has('sim')) {
            $params['sim'] = $this->simpanImage('sim', $request->file('sim'), $params['name']);
        }

        $saved = false;
        $saved = DB::transaction(function () use ($params) {
            $user = User::create($params);
            $user->branches()->sync($params['branch_id']);
            $params['user_id'] = $user->id;
            Kurir::create($params);
            return true;
        });

        if ($saved) {
            Session::flash('success', 'Kurir has been saved');
        } else {
            Session::flash('error', 'Kurir could not be saved');
        }
        return redirect('admin/kurir');
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
        $kurir = Kurir::select(DB::raw('kurirs.*,users.name,users.last_name,users.email'))
            ->join('users', 'users.id', 'kurirs.user_id')->where('kurirs.id', $id)->first();
        $branch = User::join('user_branches', 'user_branches.user_id', '=', 'users.id')->where('users.id', $kurir->user_id)->value('branch_id');
        $this->data['kurir'] = $kurir;

        $branches = Branch::orderBy('nama', 'ASC')->get();

        $this->data['branches'] = $branches->toArray();
        $this->data['branchID'] = $branch;
        return view('admin.kurir.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KurirRequest $request, $id)
    {
        $foto = false;
        $ktp = false;
        $sim = false;
        $pass = false;

        $kurir = Kurir::findOrFail($id);
        $params = $request->except('_token');

        $k = array('_token', 'alamat', 'kota', 'provinsi', 'kodepos', 'telp', 'foto', 'ktp', 'sim');
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
        if ($request->has('ktp')) {
            $ktp = true;
        } else {
            array_push($u, 'ktp');
        }
        if ($request->has('sim')) {
            $sim = true;
        } else {
            array_push($u, 'sim');
        }

        $params = $request->except($k);
        $params2 = $request->except($u);

        if ($pass) {
            $params['password'] = Hash::make($request->password);
        }
        if ($foto) {
            $params2['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['name']);
        }
        if ($ktp) {
            $params2['ktp'] = $this->simpanImage('ktp', $request->file('ktp'), $params['name']);
        }
        if ($sim) {
            $params2['sim'] = $this->simpanImage('sim', $request->file('sim'), $params['name']);
        }

        $params['level'] = '2';

        $saved = false;
        $saved = DB::transaction(function () use ($kurir, $params, $params2) {
            $kurir->update($params2);
            $user = User::findOrFail($kurir->user_id);
            $user->update($params);
            $user->branches()->sync($params['branch_id']);
            return true;
        });

        if ($saved) {
            Session::flash('success', 'Kurir has been saved');
        } else {
            Session::flash('error', 'Kurir could not be saved');
        }
        return redirect('admin/kurir');
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
            Session::flash('success', 'Kurir has been delete');
        }
        return redirect('admin/kurir');
    }

    private function simpanImage($type, $foto, $nama)
    {
        $dt = new DateTime();

        $path = public_path('uploads/kurir/' . $dt->format('Y-m-d') . '/' . $nama);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $file = $foto;
        $name =  $type . '_' . time();
        $fileName = $name . '.' . $file->getClientOriginalExtension();
        $folder = '/uploads/kurir/' . $dt->format('Y-m-d') . '/' . $nama;
        $filePath = $file->storeAs($folder, $fileName, 'public');
        return $filePath;
    }
}
