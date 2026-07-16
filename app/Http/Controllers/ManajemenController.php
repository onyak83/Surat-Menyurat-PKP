<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
// use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
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
    public function indexSifatSurat()
    {
        return view('dashboard.manajemen.sifatsurat.index');
    }

    public function getSifatSurat(Request $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $dataSifatsurat = Sifatsurat::query();

        return DataTables::eloquent($dataSifatsurat)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return view(
                    'dashboard.manajemen.sifatsurat.aksi',
                    compact('row')
                );
            })

            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function createSifatSurat()
    {
        return view('dashboard.manajemen.sifatsurat.create');
    }

    public function storeSifatSurat(Request $request)
    {
        $rules = [
            'nama_sifat' => 'required|string|max:255|unique:sifatsurats,nama_sifat',
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

            return redirect()->route('index.SifatSurat');
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

    public function editSifatSurat(string $id)
    {
        $editSifatsurat = Sifatsurat::findOrFail($id);

        return view('dashboard.manajemen.sifatsurat.edit', compact('editSifatsurat'));
    }

    public function updateSifatSurat(Request $request, string $id)
    {
        $rules = [
            'nama_sifat' => 'required|string|max:255|unique:sifatsurats,nama_sifat,' . $id,
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

            $sifatsurat->update([
                'nama_sifat' => trim($request->nama_sifat),
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Data Sifat Surat berhasil diperbarui.');

            return redirect()->route('index.SifatSurat');
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

    public function deleteSifatSurat(string $id)
    {
        DB::beginTransaction();

        try {
            $sifatsurat = Sifatsurat::findOrFail($id);
            $sifatsurat->delete();
            DB::commit();

            Alert::success('Berhasil', 'Data Sifat Surat berhasil dihapus.');

            return redirect()->route('index.SifatSurat');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete Sifat Surat Error', [
                'sifatsurat_id' => $id,
                'message'       => $e->getMessage(),
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data.');
            return redirect()->back();
        }
    }

    //instansi
    public function indexInstansi()
    {
        return view('dashboard.manajemen.instansi.index');
    }

    public function getInstansi(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $dataInstansi = Instansi::query();

        return DataTables::eloquent($dataInstansi)

        ->addIndexColumn()

        ->editColumn('nama_instansi', function ($row) {
            $alamat = $row->alamat
        ? e($row->alamat)
        : '<span class="text-muted">Alamat belum diisi</span>';

            return '
        <div class="text-start">
            <strong>' . e($row->nama_instansi) . '</strong><br>

            <small class="text-muted">
                <i class="fas fa-map-marker-alt text-danger"></i>
                ' . $alamat . '
            </small>
        </div>
    ';
        })
        ->editColumn('kode_instansi', function ($row) {
            return $row->kode_instansi ?: '-';
        })
        ->editColumn('telepon', function ($row) {
            return $row->telepon ?: '-';
        })
        ->editColumn('status', function ($row) {
            if ($row->status) {
                return '<span class="badge badge-success">Aktif</span>';
            }

            return '<span class="badge badge-danger">Tidak Aktif</span>';
        })
        ->addColumn('aksi', function ($row) {
            return view('dashboard.manajemen.instansi.aksi', compact('row'));
        })

        ->rawColumns(['status', 'aksi', 'nama_instansi'])

        ->make(true);
    }

    public function createInstansi()
    {
        return view('dashboard.manajemen.instansi.create');
    }

    // public function storeInstansi(Request $request)
    // {
    //     $rules = [
    //     'kode_instansi'  => 'nullable|string|max:30|unique:instansis,kode_instansi',
    //     'nama_instansi'  => 'required|string|max:255|unique:instansis,nama_instansi',
    //     'jenis_instansi' => 'required|in:Kementerian,Lembaga,Pemerintah Provinsi,Pemerintah Kabupaten/Kota,OPD,Kecamatan,Kelurahan,BUMN,BUMD,Swasta,Perguruan Tinggi,Organisasi,Lainnya',
    //     'alamat'         => 'nullable|string',
    //     'telepon'        => 'nullable|string|max:30',
    //     'email'          => 'nullable|email|max:255',
    //     'status'         => 'nullable|boolean',
    //     ];

    //     $messages = [
    //         'kode_instansi.unique'      => 'Kode Instansi sudah digunakan.',
    //         'kode_instansi.max'         => 'Kode Instansi maksimal 30 karakter.',

    //         'nama_instansi.required'    => 'Nama Instansi wajib diisi.',
    //         'nama_instansi.unique'      => 'Nama Instansi sudah tersedia.',
    //         'nama_instansi.max'         => 'Nama Instansi maksimal 255 karakter.',

    //         'jenis_instansi.required'   => 'Jenis Instansi wajib dipilih.',
    //         'jenis_instansi.in'         => 'Jenis Instansi tidak valid.',

    //         'telepon.max'               => 'Nomor Telepon maksimal 30 karakter.',

    //         'email.email'               => 'Format Email tidak valid.',
    //         'email.max'                 => 'Email maksimal 255 karakter.',
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     DB::beginTransaction();

    //     try {
    //         Instansi::create([
    //             'kode_instansi'  => $request->filled('kode_instansi') ? trim($request->kode_instansi) : null,
    //             'nama_instansi'  => trim($request->nama_instansi),
    //             'jenis_instansi' => $request->jenis_instansi,
    //             'alamat'         => $request->filled('alamat') ? trim($request->alamat) : null,
    //             'telepon'        => $request->filled('telepon') ? trim($request->telepon) : null,
    //             'email'          => $request->filled('email') ? trim($request->email) : null,
    //             'status'         => $request->has('status') ? $request->status : true,
    //             'created_by'     => auth()->check() ? auth()->user()->id : null,
    //         ]);

    //         DB::commit();

    //         Alert::success('Berhasil', 'Data Instansi berhasil ditambahkan.');

    //         return redirect()->route('index.Instansi');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         Log::error('Store Instansi Error', [
    //             'request' => $request->except('_token'),
    //             'message' => $e->getMessage(),
    //             'file'    => $e->getFile(),
    //             'line'    => $e->getLine(),
    //         ]);

    //         Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data.');

    //         return redirect()->back()->withInput();
    //     }
    // }

    public function storeInstansi(Request $request)
    {
        $rules = [
            'kode_instansi'  => 'nullable|string|max:30|unique:instansis,kode_instansi',
            'nama_instansi'  => 'required|string|max:255|unique:instansis,nama_instansi',
            'jenis_instansi' => 'required|in:Kementerian,Lembaga,Pemerintah Provinsi,Pemerintah Kabupaten/Kota,OPD,Kecamatan,Kelurahan,BUMN,BUMD,Swasta,Perguruan Tinggi,Organisasi,Lainnya',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:255',
            'status'         => 'nullable|boolean',
        ];

        $messages = [
            'kode_instansi.unique'      => 'Kode Instansi sudah digunakan.',
            'kode_instansi.max'         => 'Kode Instansi maksimal 30 karakter.',

            'nama_instansi.required'    => 'Nama Instansi wajib diisi.',
            'nama_instansi.unique'      => 'Nama Instansi sudah tersedia.',
            'nama_instansi.max'         => 'Nama Instansi maksimal 255 karakter.',

            'jenis_instansi.required'   => 'Jenis Instansi wajib dipilih.',
            'jenis_instansi.in'         => 'Jenis Instansi tidak valid.',

            'telepon.max'               => 'Nomor Telepon maksimal 30 karakter.',

            'email.email'               => 'Format Email tidak valid.',
            'email.max'                 => 'Email maksimal 255 karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $instansi = Instansi::create([
                'kode_instansi'  => $request->filled('kode_instansi')
                    ? trim($request->kode_instansi)
                    : null,

                'nama_instansi'  => trim($request->nama_instansi),

                'jenis_instansi' => $request->jenis_instansi,

                'alamat'         => $request->filled('alamat')
                    ? trim($request->alamat)
                    : null,

                'telepon'        => $request->filled('telepon')
                    ? trim($request->telepon)
                    : null,

                'email'          => $request->filled('email')
                    ? trim($request->email)
                    : null,

                'status'         => $request->filled('status'),

                'created_by'     => Auth::id(),
            ]);

            DB::commit();

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Instansi berhasil ditambahkan.',
                    'data' => [
                        'id' => $instansi->id,
                        'nama_instansi' => $instansi->nama_instansi,
                    ]
                ]);
            }

            Alert::success('Berhasil', 'Data Instansi berhasil ditambahkan.');

            return redirect()->route('index.Instansi');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Store Instansi Error', [
                'request' => $request->except('_token'),
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data.',
                ], 500);
            }

            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data.');

            return redirect()->back()->withInput();
        }
    }

    public function editInstansi(string $id)
    {
        $editInstansi = Instansi::findOrFail($id);

        return view('dashboard.manajemen.instansi.edit', compact('editInstansi'));
    }

    public function updateInstansi(Request $request, string $id)
    {
        $rules = [
            'kode_instansi'  => 'nullable|string|max:30|unique:instansis,kode_instansi,' . $id,
            'nama_instansi'  => 'required|string|max:255|unique:instansis,nama_instansi,' . $id,
            'jenis_instansi' => 'required|in:Kementerian,Lembaga,Pemerintah Provinsi,Pemerintah Kabupaten/Kota,OPD,Kecamatan,Kelurahan,BUMN,BUMD,Swasta,Perguruan Tinggi,Organisasi,Lainnya',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:255',
            'status'         => 'nullable|boolean',
        ];

        $messages = [
            'kode_instansi.unique'      => 'Kode Instansi sudah digunakan.',
            'kode_instansi.max'         => 'Kode Instansi maksimal 30 karakter.',
            'nama_instansi.required'    => 'Nama Instansi wajib diisi.',
            'nama_instansi.unique'      => 'Nama Instansi sudah tersedia.',
            'nama_instansi.max'         => 'Nama Instansi maksimal 255 karakter.',
            'jenis_instansi.required'   => 'Jenis Instansi wajib dipilih.',
            'jenis_instansi.in'         => 'Jenis Instansi tidak valid.',
            'telepon.max'               => 'Nomor Telepon maksimal 30 karakter.',
            'email.email'               => 'Format Email tidak valid.',
            'email.max'                 => 'Email maksimal 255 karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        DB::beginTransaction();

        try {
            $instansi = Instansi::findOrFail($id);
            $instansi->update([
            'kode_instansi'  => $request->filled('kode_instansi') ? trim($request->kode_instansi) : null,
            'nama_instansi'  => trim($request->nama_instansi),
            'jenis_instansi' => $request->jenis_instansi,
            'alamat'         => $request->filled('alamat') ? trim($request->alamat) : null,
            'telepon'        => $request->filled('telepon') ? trim($request->telepon) : null,
            'email'          => $request->filled('email') ? trim($request->email) : null,
            'status'         => $request->has('status') ? 1 : 0,
        ]);

            DB::commit();

            Alert::success('Berhasil', 'Data Instansi berhasil diperbarui.');

            return redirect()->route('index.Instansi');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Update Instansi Error', [
            'instansi_id' => $id,
            'request'     => $request->except('_token', '_method'),
            'message'     => $e->getMessage(),
            'file'        => $e->getFile(),
            'line'        => $e->getLine(),
        ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data.');

            return redirect()->back()->withInput();
        }
    }

    public function deleteInstansi(string $id)
    {
        DB::beginTransaction();

        try {
            $delInstansi = Instansi::findOrFail($id);
            $delInstansi->delete();
            DB::commit();

            Alert::success('Berhasil', 'Data Instansi berhasil dihapus.');

            return redirect()->route('index.Instansi');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete Instansi Error', [
                'sifatsurat_id' => $id,
                'message'       => $e->getMessage(),
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data.');
            return redirect()->back();
        }
    }
}
