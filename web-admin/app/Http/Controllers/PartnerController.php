<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Nette\Utils\DateTime;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::orderBy('nama', 'ASC');
        $this->data['partners'] = $partners->paginate(10);
        return view('admin.partner.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['partner'] = null;
        return view('admin.partner.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PartnerRequest $request)
    {
        $params = $request->except('_token');
        if ($request->has('logo')) {
            $dt = new DateTime();

            $path = public_path('uploads/logo/' . $dt->format('Y-m-d'));
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $file = $request->file('logo');
            $name =  Str::slug($params['nama']) . '_' . time();
            $fileName = $name . '.' . $file->getClientOriginalExtension();
            $folder = '/uploads/logo/' . $dt->format('Y-m-d');
            $filePath = $file->storeAs($folder, $fileName, 'public');
            $params['logo'] = $filePath;
        }
        if (Partner::create($params)) {
            Session::flash('success', 'partner has been saved');
        } else {
            Session::flash('error', 'partner could not be saved');
        }
        return redirect('admin/partner');
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
        $partner = Partner::findOrFail($id);
        $this->data['partner'] = $partner;
        return view('admin.partner.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(partnerRequest $request, $id)
    {
        $params = $request->except('_token');
        if ($request->has('logo')) {
            $dt = new DateTime();
            $path = public_path('uploads/logo/' . $dt->format('Y-m-d'));
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $file = $request->file('logo');
            $name =  Str::slug($params['nama']) . '_' . time();
            $fileName = $name . '.' . $file->getClientOriginalExtension();
            $folder = '/uploads/logo/' . $dt->format('Y-m-d');
            $filePath = $file->storeAs($folder, $fileName, 'public');
            $params['logo'] = $filePath;
        } else {
            $params = $request->except('logo');
        }

        $partner = Partner::findOrFail($id);
        if ($partner->update($params)) {
            Session::flash('success', 'partner has been update');
        } else {
            Session::flash('error', 'partner could not be saved');
        }
        return redirect('admin/partner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        if ($partner->delete()) {
            Session::flash('success', 'partner has been delete');
        }
        return redirect('admin/partner');
    }
}
