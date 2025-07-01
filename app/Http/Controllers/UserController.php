<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\MasterPenerimaEksternal;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use DB;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $roles = Role::pluck('name', 'name')->all();
        $data = User::orderBy('id', 'DESC')->get();
        return view('users.index', compact('data', 'roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();
        $departmen = Departemen::get();
        return view('users.create', compact('roles', 'departmen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        // dd($request->hasFile('Foto'));

        if ($request->hasFile('Foto')) {
            $file = $request->file('Foto');
            $file->storeAs('public/Foto', $file->getClientOriginalName());
            $data['Foto'] = $file->getClientOriginalName();
        }
        if ($request->hasFile('DigitalSign')) {
            $file = $request->file('DigitalSign');
            $file->storeAs('public/DigitalSign', $file->getClientOriginalName());
            $data['DigitalSign'] = $file->getClientOriginalName();
        }

        // dd($input);
        $input['password'] = Hash::make($input['password']);
        $input['akses'] = $request->roles[0];

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $departmen = Departemen::get();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole', 'departmen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nip' => 'required|string|unique:users,nip,' . $id,
            'department' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'roles' => 'required|array',
            'password' => 'nullable|min:6|same:confirm-password',
            'Foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'DigitalSign' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $input = $request->all();
        if ($request->hasFile('Foto')) {
            $file = $request->file('Foto');
            $file->storeAs('public/Foto', $file->getClientOriginalName());
            $input['Foto'] = $file->getClientOriginalName();
        }
        if ($request->hasFile('DigitalSign')) {
            $file = $request->file('DigitalSign');
            $file->storeAs('public/DigitalSign', $file->getClientOriginalName());
            $input['DigitalSign'] = $file->getClientOriginalName();
        }
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()
            ->back()
            ->with('success', 'User updated successfully');
    }

    public function getUsers($id)
    {
        $user = User::with('getDepartmen')->find($id);
        if (!$user) {
            return response()->json(['message' => 'User Tidak Ditemukan'], 404);
        }
        return response()->json($user);
    }

    public function getUsersEks($id)
    {
        $user = MasterPenerimaEksternal::find($id);
        if (!$user) {
            return response()->json(['message' => 'User Tidak Ditemukan'], 404);
        }
        return response()->json($user);
    }

    public function getCCInternal(Request $request)
    {
        $iduser = $request->id;
        // dd($iduser);
        $units = User::whereNot('id', $iduser)->get(['id', 'name']);

        return response()->json($units);
    }
    public function getCCExternal(Request $request)
    {
        $iduser = $request->id;
        $units = MasterPenerimaEksternal::whereNot('id', $iduser)->get(['id', 'Nama']);

        return response()->json($units);
    }
    public function getBCCInternal(Request $request)
    {
        $iduser = $request->id;
        $iduser2 = $request->id2;
        $units = User::whereNot('id', $iduser2)
            ->whereNotIn('id', [$iduser])
            ->get(['id', 'name']);

        return response()->json($units);
    }
    public function getCCExternal2(Request $request)
    {
        $iduser = $request->id;
        $iduser2 = $request->id2;
        $units = MasterPenerimaEksternal::whereNot('id', $iduser2)
            ->whereNotIn('id', [$iduser])
            ->get(['id', 'Nama']);

        return response()->json($units);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
