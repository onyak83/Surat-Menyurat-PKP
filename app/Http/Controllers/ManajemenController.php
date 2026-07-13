<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
// use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Sifatsurat;
use App\Models\User;

class ManajemenController extends Controller
{
    public function indexUser()
    {
        return view('dashboard.manajemen.user.index');
    }

    public function getUser(Request $request)
    {
        if ($request->ajax()) {
            $dataUser = User::with('role') // Eager Loading untuk menghindari query berulang
                ->whereIn('role_id', [1, 2]) // Perbaikan di bagian where
                ->orderBy('created_at', 'desc');

            return datatables()->of($dataUser)

            ->addColumn('aksi', function ($row) {
                return view('dashboard.manajemen.user.aksi', ['user' => $row]);
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
    }

    public function createUser()
    {
        $role=Role::all();

        return view('dashboard.manajemen.user.create', compact('role'));
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5',
            'role_id'  => 'required|exists:roles,id',
        ];

        $messages = [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 5 karakter.',
            'role_id.required'   => 'Role wajib dipilih.',
            'role_id.exists'     => 'Role tidak ditemukan.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {

            User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role_id'   => $request->role_id,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Data user berhasil ditambahkan.');

            return redirect()->route('index.User');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Store User Error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data.');

            return redirect()->back()->withInput();
        }
    }

    public function editUser(string $id)
    {
        $role = Role::all();

        $editUser = User::findOrFail($id);

        return view('dashboard.manajemen.user.edit', compact('role', 'editUser'));
    }

    public function updateUser(Request $request, string $id)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:5',
            'role_id'  => 'required|exists:roles,id',
        ];

        $messages = [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.min'       => 'Password minimal 5 karakter.',
            'role_id.required'   => 'Role wajib dipilih.',
            'role_id.exists'     => 'Role tidak ditemukan.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            $user->name    = $request->name;
            $user->email   = $request->email;
            $user->role_id = $request->role_id;

            // Password hanya diubah jika diisi
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            DB::commit();

            Alert::success('Berhasil', 'Data user berhasil diperbarui.');

            return redirect()->route('index.User');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Update User Error', [
                'user_id' => $id,
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data.');

            return redirect()->back()->withInput();
        }
    }

    public function deleteUser(string $id)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            $user->delete();

            DB::commit();

            Alert::success('Berhasil', 'Data berhasil dihapus.');

            return redirect()->route('index.User');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Delete User Error', [
                'user_id' => $id,
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data.');

            return redirect()->back();
        }
    }

    //sifat surat
    public function indexSifatsurat()
    {
        return view('dashboard.manajemen.sifatsurat.index');
    }

    public function getSifatsurat(Request $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $dataSifatsurat = Sifatsurat::query();

        return DataTables::eloquent($dataSifatsurat)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return view(
                    'dashboard.manajemen.sifatsurat.aksi', compact('row'));
            })

            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function createSifatsurat()
    {
        return view('dashboard.manajemen.sifatsurat.create');
    }

    public function storeSifatsurat(Request $request)
    {
        $rules = [
            'nama_sifat' => 'required|string|max:255|unique:sifatsurat,nama_sifat',
        ];

        $messages = [
            'nama_sifat.required' => 'Nama Sifat Surat wajib diisi.',
            'nama_sifat.unique'   => 'Nama Sifat Surat sudah tersedia.',
            'nama_sifat.max'      => 'Nama Sifat Surat maksimal 255 karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {

            Sifatsurat::create([
                'nama_sifat' => trim($request->nama_sifat),
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Data Sifat Surat berhasil ditambahkan.');

            return redirect()->route('index.Sifatsurat');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Store Sifat Surat Error', [
                'request' => $request->except('_token'),
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data.');

            return redirect()->back()->withInput();
        }
    }

    public function editSifatsurat(string $id)
    {
        $editSifatsurat = Sifatsurat::findOrFail($id);

        return view('dashboard.manajemen.sifatsurat.edit', compact('editSifatsurat'));
    }

    public function updateSifatsurat(Request $request, string $id)
    {
        $rules = [
            'nama_sifat' => 'required|string|max:255|unique:sifatsurat,nama_sifat,' . $id,
        ];

        $messages = [
            'nama_sifat.required' => 'Nama Sifat Surat wajib diisi.',
            'nama_sifat.unique'   => 'Nama Sifat Surat sudah tersedia.',
            'nama_sifat.max'      => 'Nama Sifat Surat maksimal 255 karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {

            $sifatsurat = Sifatsurat::findOrFail($id);
            $sifatsurat->nama_sifat = trim($request->nama_sifat);
            $sifatsurat->save();

            DB::commit();

            Alert::success('Berhasil', 'Data Sifat Surat berhasil diperbarui.');

            return redirect()->route('index.Sifatsurat');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Update Sifat Surat Error', [
                'sifatsurat_id' => $id,
                'request'       => $request->except('_token', '_method'),
                'message'       => $e->getMessage(),
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data.');

            return redirect()->back()->withInput();
        }
    }

    public function deleteSifatsurat(string $id)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            $user->delete();

            DB::commit();

            Alert::success('Berhasil', 'Data berhasil dihapus.');

            return redirect()->route('index.User');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Delete User Error', [
                'user_id' => $id,
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data.');

            return redirect()->back();
        }
    }
}
