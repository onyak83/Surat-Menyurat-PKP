<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\Surat;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Surat
        $totalSuratMasuk = Surat::where('jenis_surat', 'masuk')->count();
        $totalSuratKeluar = Surat::where('jenis_surat', 'keluar')->count();

        // Surat Hari Ini
        $suratMasukHariIni = Surat::where('jenis_surat', 'masuk')
        ->whereDate('created_at', Carbon::today())
        ->count();
        // return $suratMasukHariIni;

        $suratKeluarHariIni = Surat::where('jenis_surat', 'keluar')
        ->whereDate('created_at', Carbon::today())
        ->count();

        return view('dashboard.dashboard', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'suratMasukHariIni',
            'suratKeluarHariIni'
        ));
    }

    public function getInstansiDropdown()
    {
        $viewInstansi = Instansi::where('status', true)
            ->orderBy('nama_instansi', 'ASC')
            ->get(['id', 'nama_instansi','jenis_instansi']);

        return response()->json($viewInstansi);
    }

    public function indexSurat()
    {
        return view('dashboard.surat.index');
    }

    public function getSurat(Request $request)
    {
        if ($request->ajax()) {
            $dataSurat = Surat::with(['sifatSurat','instansi'])->orderBy('id', 'desc');

            return datatables()->of($dataSurat)
            ->editColumn('tgl_diterima', function ($row) {
                return $row->tgl_diterima
                    ? Carbon::parse($row->tgl_diterima)
                        ->locale('id')
                        ->translatedFormat('d M Y')
                    : '-';
            })

            ->editColumn('no_agenda', function ($row) {
                return $row->no_agenda ?: '-';
            })

            ->editColumn('no_surat', function ($row) {
                $tglSurat = Carbon::parse($row->tgl_surat)
                    ->locale('id')
                    ->translatedFormat('d M Y');

                $tglDiterima = $row->tgl_diterima
                    ? Carbon::parse($row->tgl_diterima)
                        ->locale('id')
                        ->translatedFormat('d M Y')
                    : '-';

                $sifatSurat = optional($row->sifatSurat)->nama_sifat ?: '-';
                $lampiran   = !empty($row->lampiran) ? $row->lampiran : '-';

                $html = '
                    <div class="text-start">
                        <small><b>No. Surat</b> : '.$row->no_surat.'</small><br>
                        <small><b>Tgl. Surat</b> : '.$tglSurat.'</small><br>';

                // Tampilkan hanya untuk Surat Masuk
                if ($row->jenis_surat == 'masuk') {
                    $html .= '
                        <small><b>Tgl. Diterima</b> : '.$tglDiterima.'</small><br>';
                }

                $html .= '
                        <small><b>Sifat Surat</b> : '.$sifatSurat.'</small><br>
                        <small><b>Lampiran</b> : '.$lampiran.'</small>
                    </div>';

                return $html;
            })
            ->addColumn('lihatfile', function ($row) {
                return view('dashboard.surat.lihatfile', ['surat' => $row]);
            })
            ->addColumn('instansi', function ($row) {
                return optional($row->instansi)->nama_instansi ?? '-';
            })
            ->addColumn('aksi', function ($row) {
                return view('dashboard.surat.aksi', ['surat' => $row]);
            })
            ->rawColumns(['no_surat', 'lihatfile', 'instansi', 'aksi'])
            ->make(true);
        }
    }

    public function createSurat()
    {
        $sifatSurat = DB::table('sifatsurats')->get();
        $instansi = Instansi::where('status', true)
            ->orderBy('nama_instansi')
            ->get();

        return view('dashboard.surat.create', compact('sifatSurat', 'instansi'));
    }

    public function storeSurat(Request $request)
    {
        $rules = [
            'jenis_surat'    => 'required|in:masuk,keluar',
            'sifat_surat_id' => 'required|exists:sifatsurats,id',
            'no_surat'       => 'required|string|max:255|unique:surats,no_surat',
            'tgl_surat'      => 'required|date',
            'tgl_diterima'   => ['nullable','required_if:jenis_surat,masuk','date','after_or_equal:tgl_surat'],
            'instansi_id'    => 'required|exists:instansis,id',
            'perihal'        => 'required|string|max:255',
            'lampiran'       => 'nullable|string|max:255',
            'file_surat'     => 'required|file|mimes:pdf|max:2048',
            'keterangan'     => 'nullable|string',
        ];

        $messages = [
            'jenis_surat.required'     => 'Jenis Surat wajib dipilih.',
            'jenis_surat.in'           => 'Jenis Surat tidak valid.',

            'sifat_surat_id.required'  => 'Sifat Surat wajib dipilih.',
            'sifat_surat_id.exists'    => 'Sifat Surat tidak ditemukan.',

            'no_surat.required'        => 'Nomor Surat wajib diisi.',
            'no_surat.unique'          => 'Nomor Surat sudah terdaftar.',
            'no_surat.max'             => 'Nomor Surat maksimal 255 karakter.',

            'tgl_surat.required'       => 'Tanggal Surat wajib diisi.',
            'tgl_surat.date'           => 'Format Tanggal Surat tidak valid.',

            'tgl_diterima.required_if' => 'Tanggal Diterima wajib diisi untuk Surat Masuk.',
            'tgl_diterima.date'        => 'Format Tanggal Diterima tidak valid.',
            'tgl_diterima.after_or_equal' => 'Tanggal Diterima tidak boleh lebih kecil dari Tanggal Surat.',

            'instansi_id.required'     => 'Instansi wajib dipilih.',
            'instansi_id.exists'       => 'Instansi tidak ditemukan.',

            'perihal.required'         => 'Perihal wajib diisi.',
            'perihal.max'              => 'Perihal maksimal 255 karakter.',

            'lampiran.max'             => 'Lampiran maksimal 255 karakter.',

            'file_surat.required'      => 'File Surat wajib diunggah.',
            'file_surat.file'          => 'File Surat tidak valid.',
            'file_surat.mimes'         => 'File Surat harus berformat PDF.',
            'file_surat.max'           => 'Ukuran File Surat maksimal 2 MB.',

            'keterangan.string'        => 'Keterangan harus berupa teks.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $folder = null;
        $namaFile = null;

        try {
            // upload file
            $file = $request->file('file_surat');
            if ($request->jenis_surat == 'masuk') {
                $folder = 'surat/masuk/' . now()->year;
                $prefix = 'SM';
            } else {
                $folder = 'surat/keluar/' . now()->year;
                $prefix = 'SK';
            }

            $namaFile = $prefix . '_' .now()->format('YmdHis') . '_' .Str::upper(Str::random(8)) .'.pdf';
            $file->storeAs($folder, $namaFile, 'public');

            // generate no agenda surat masuk
            $noAgenda = null;
            if ($request->jenis_surat == 'masuk') {
                $tahun = now()->year;
                $lastNumber = Surat::where('jenis_surat', 'masuk')
                    ->whereYear('created_at', $tahun)
                    ->lockForUpdate()
                    ->selectRaw('MAX(CAST(SUBSTRING_INDEX(no_agenda,"/",1) AS UNSIGNED)) as nomor')
                    ->value('nomor');
                $nextNumber = str_pad(($lastNumber ?? 0) + 1, 4, '0', STR_PAD_LEFT);
                $noAgenda = $nextNumber . '/DPUPR-OKI/' . $tahun;
            }

            // simpan data
            Surat::create([
                'jenis_surat'    => $request->jenis_surat,
                'no_agenda'      => $noAgenda,
                'no_surat'       => trim($request->no_surat),
                'tgl_surat'      => $request->tgl_surat,
                'tgl_diterima'   => $request->tgl_diterima,
                'instansi_id'    => $request->instansi_id,
                'perihal'        => trim($request->perihal),
                'lampiran'       => $request->lampiran ? trim($request->lampiran) : null,
                'sifat_surat_id' => $request->sifat_surat_id,
                'file_surat'     => $folder . '/' . $namaFile,
                'keterangan'     => $request->keterangan ? trim($request->keterangan) : null,
                'created_by'     => Auth::id(),

            ]);

            DB::commit();

            Alert::success('Berhasil', 'Data surat berhasil disimpan.');

            return redirect()->route('index.Surat');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($namaFile && Storage::disk('public')->exists($folder . '/' . $namaFile)) {
                Storage::disk('public')->delete($folder . '/' . $namaFile);
            }

            Log::error('Store Surat Error', [
                'request' => $request->except('_token'),
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data.');
            return redirect()->back()->withInput();
        }
    }

    public function editSurat(string $id)
    {
        $sifatSurat = DB::table('sifatsurats')->get();
        $instansi = Instansi::where('status', true)
            ->orderBy('nama_instansi')
            ->get();

        $surat = Surat::findOrFail($id);

        return view('dashboard.surat.edit', compact('surat', 'sifatSurat', 'instansi'));
    }

    public function updateSurat(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
        'jenis_surat'  => 'required|in:masuk,keluar',
        'no_agenda'    => 'nullable|string|max:255',
        'sifat_surat_id' => 'required|exists:sifatsurats,id',
        'no_surat'     => 'required|string|max:255',
        'tgl_surat'    => 'required|date',
        'tgl_diterima' => 'nullable|date',
        'instansi_id'  => 'required|exists:instansis,id',
        'perihal'      => 'required|string|max:255',
        'lampiran'     => 'nullable|string|max:255',
        'file_surat'   => 'nullable|file|mimes:pdf|max:2048',
        'keterangan'   => 'nullable|string|max:255',
    ]);

        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        DB::beginTransaction();

        $folder = '';
        $fileSuratBaru = '';

        try {
            $surat = Surat::findOrFail($id);

            // Default gunakan file lama
            $pathFile = $surat->file_surat;

            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');

                if ($file->getMimeType() != 'application/pdf') {
                    return redirect()->back()
                    ->withErrors([
                        'file_surat' => 'File yang diupload harus berupa PDF.'
                    ])
                    ->withInput();
                }

                if ($request->jenis_surat == 'masuk') {
                    $folder = 'File_Surat/Masuk/' . date('Y');
                    $prefix = 'File_Surat_Masuk';
                } else {
                    $folder = 'File_Surat/Keluar/' . date('Y');
                    $prefix = 'File_Surat_Keluar';
                }

                $fileSuratBaru = $prefix . '_' . date('YmdHis') . '_' . Str::uuid() . '.pdf';

                $file->storeAs($folder, $fileSuratBaru, 'public');

                // Simpan path file baru
                $pathFile = $folder . '/' . $fileSuratBaru;

                // Hapus file lama jika ada
                if (!empty($surat->file_surat) && Storage::disk('public')->exists($surat->file_surat)) {
                    Storage::disk('public')->delete($surat->file_surat);
                }
            }

            $surat->update([
            'jenis_surat'  => $request->jenis_surat,
            'no_agenda'    => $request->no_agenda,
            'sifat_surat_id' => $request->sifat_surat_id,
            'no_surat'     => $request->no_surat,
            'tgl_surat'    => $request->tgl_surat,
            'tgl_diterima' => $request->tgl_diterima,
            'instansi_id'  => $request->instansi_id,
            'perihal'      => $request->perihal,
            'lampiran'     => $request->lampiran,
            'file_surat'   => $pathFile,
            'keterangan'   => $request->keterangan,
        ]);

            DB::commit();

            Alert::success('Berhasil', 'Data surat berhasil diperbarui.');

            return redirect()->route('index.Surat');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file baru jika database gagal update
            if (!empty($fileSuratBaru)) {
                if (Storage::disk('public')->exists($folder . '/' . $fileSuratBaru)) {
                    Storage::disk('public')->delete($folder . '/' . $fileSuratBaru);
                }
            }

            Log::error('Update Surat Error', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data.');

            return redirect()->back()->withInput();
        }
    }

    public function deleteSurat(string $id)
    {
        DB::beginTransaction();

        try {
            $surat = Surat::findOrFail($id);

            // Hapus file surat jika ada
            if (!empty($surat->file_surat) && Storage::disk('public')->exists($surat->file_surat)) {
                Storage::disk('public')->delete($surat->file_surat);
            }

            $surat->delete();

            DB::commit();

            Alert::success('Berhasil', 'Data surat berhasil dihapus.');

            return redirect()->route('index.Surat');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Delete Surat Error', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data.');

            return redirect()->back();
        }
    }

    public function indexAgendaSuratMasuk()
    {
        $sifatSurat = DB::table('sifatsurats')->get();
        $instansiview = DB::table('instansis')->get();

        return view('dashboard.laporan.agendasuratmasuk.index', compact('sifatSurat', 'instansiview'));
    }

    public function getAgendaSuratMasuk(Request $request)
    {
        $query = Surat::with(['sifatSurat','instansi'])
            ->where('jenis_surat', 'masuk');

        if ($request->filled('tgl_awal')) {
            $query->whereDate('tgl_diterima', '>=', $request->tgl_awal);
        }

        if ($request->filled('tgl_akhir')) {
            $query->whereDate('tgl_diterima', '<=', $request->tgl_akhir);
        }

        if ($request->filled('tgl_surat')) {
            $query->whereDate('tgl_surat', '<=', $request->tgl_surat);
        }

        if ($request->filled('sifat_surat')) {
            $query->where('sifat_surat_id', $request->sifat_surat);
        }

        if ($request->filled('instansi_id')) {
            $query->where('instansi_id', $request->instansi_id);
        }

        $query->orderByRaw("
            CAST(SUBSTRING_INDEX(no_agenda,'/',1) AS UNSIGNED) ASC
        ");

        return DataTables::of($query)

        ->addIndexColumn()

        ->editColumn('no_agenda', function ($row) {
            return $row->no_agenda;
        })

        ->editColumn('tgl_diterima', function ($row) {
            return Carbon::parse($row->tgl_diterima)
                ->locale('id')
                ->translatedFormat('d F Y');
        })

        ->editColumn('sifat_surat', function ($row) {
            return optional($row->sifatSurat)->nama_sifat ?? '-';
        })

        ->editColumn('no_surat', function ($row) {
            return '
                <div>
                    <strong>'.$row->no_surat.'</strong><br>
                    <small class="text-muted">'.
                        Carbon::parse($row->tgl_surat)
                            ->locale('id')
                            ->translatedFormat('d F Y')
                    .'</small>
                </div>';
        })

        ->addColumn('instansi', function ($row) {
            return optional($row->instansi)->nama_instansi ?? '-';
        })

        ->editColumn('perihal', function ($row) {
            return e($row->perihal);
        })

        ->addColumn('lihatsurat', function ($row) {
            return view('dashboard.laporan.agendasuratmasuk.lihatsurat', compact('row'));
        })

        ->rawColumns(['no_surat','instansi','perihal', 'lihatsurat'])
        ->make(true);
    }

        public function indexArsipDigital()
    {
        $instansi = Instansi::orderBy('nama_instansi')
            ->get();

        return view('dashboard.laporan.arsipsuratdigital.index', compact('instansi'));
    }

    public function getArsipDigital(Request $request)
    {
        $arsip = Surat::with(['instansi', 'sifatSurat'])
            ->where('jenis_surat', $request->jenis_surat)

            ->when($request->nomor_surat, function ($q) use ($request) {
                $q->where('no_surat', 'like', '%' . $request->nomor_surat . '%');
            })

            ->when($request->tgl_surat, function ($q) use ($request) {
                $q->whereDate('tgl_surat', $request->tgl_surat);
            })

            ->when($request->perihal, function ($q) use ($request) {
                $q->where('perihal', 'like', '%' . $request->perihal . '%');
            })

            ->when($request->instansi_id, function ($q) use ($request) {
                $q->where('instansi_id', $request->instansi_id);
            })

            ->latest()
            ->get()

            // LETAKNYA DI SINI
            ->map(function ($item) {
                $item->tgl_surat = Carbon::parse($item->tgl_surat)
                    ->translatedFormat('d F Y');
                return $item;
            });

        return response()->json($arsip);
    }

    public function detailArsipDigital(string $id)
    {
        $surat = Surat::with(['instansi','sifatSurat','user'])
            ->findOrFail($id);

        return response()->json($surat);
    }

}
