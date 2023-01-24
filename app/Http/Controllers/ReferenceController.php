<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangJenis;
use App\Models\BarangKategori;
use App\Models\BarangSatuan;
use App\Models\Pasien;
use App\Models\Pegawai;
use App\Models\Poli;
use App\Models\PoliSub;
use App\Models\Registrasi;
use App\Models\Tindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReferenceController extends Controller
{
    //

    public function getIcd9(Request $request)
    {

        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;


        $num_data = DB::table('icd9')->select(['code']);


        if (isset($request->id) && $request->id) {
            $num_data->where('code', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(code) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(short_description) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(description) like '%" . strtolower($q) . "%'");
            });
        }
        $total_count = $num_data->count();
        $row_data = DB::table('icd9')->select('*');

        if (isset($request->id) && $request->id) {
            $row_data->where('code', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(code) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(short_description) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(description) like '%" . strtolower($q) . "%'");
            });
        }

        $row_data->orderBy('code', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharseIcd9($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharseIcd9($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->code,
                'text' => $value->code . ' - ' . $value->short_description,
            );
        }
        return $res_array;
    }

    public function getIcd10(Request $request)
    {

        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;


        $num_data = DB::table('icd10')->select(['code_icd']);


        if (isset($request->id) && $request->id) {
            $num_data->where('code_icd', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(code_icd) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(title_icd) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(title_id) like '%" . strtolower($q) . "%'");
            });
        }
        $total_count = $num_data->count();
        $row_data = DB::table('icd10')->select('*');

        if (isset($request->id) && $request->id) {
            $row_data->where('code_icd', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(code_icd) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(title_icd) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(title_id) like '%" . strtolower($q) . "%'");
            });
        }

        $row_data->orderBy('code_icd', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharseIcd10($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharseIcd10($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->code_icd,
                'text' => $value->code_icd . ' - ' . $value->title_icd,
                'title_id' => $value->title_id,
            );
        }
        return $res_array;
    }

    public function getPasien(Request $request)
    {

        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;


        $num_data = Pasien::select(['id']);


        if (isset($request->id) && $request->id) {
            $num_data->where('id', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(no_rm) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(nama_pasien) like '%" . strtolower($q) . "%'");
            });
        }
        $total_count = $num_data->count();
        $row_data = Pasien::select('*');

        if (isset($request->id) && $request->id) {
            $row_data->where('id', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(no_rm) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(nama_pasien) like '%" . strtolower($q) . "%'");
            });
        }

        $row_data->orderBy('no_rm', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharsePasien($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharsePasien($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->id,
                'text' => $value->no_rm . ' - ' . $value->nama_pasien,
                'alamat' => $value->alamat,
                'tgl_lahir' => $value->tgl_lahir,
                'usia' => hitung_umur($value->tgl_lahir),
            );
        }
        return $res_array;
    }

    public function getPoli(Request $request)
    {

        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;


        $num_data = Poli::select(['id']);
        $num_data->where('stat', 'Aktif');

        if (isset($request->id) && $request->id) {
            $num_data->where('id', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(kode) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(nama) like '%" . strtolower($q) . "%'");
            });
        }
        $total_count = $num_data->count();
        $row_data = Poli::select('*');
        $row_data->where('stat', 'Aktif');

        if (isset($request->id) && $request->id) {
            $row_data->where('id', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(kode) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(nama) like '%" . strtolower($q) . "%'");
            });
        }

        $row_data->orderBy('kode', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharsePoli($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharsePoli($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->id,
                'text' => $value->nama,
                'kode' => $value->kode,
            );
        }
        return $res_array;
    }

    public function getPoliSub(Request $request)
    {

        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;


        $num_data = PoliSub::select(['id']);
        $num_data->where('stat', 'Aktif');

        if (isset($request->id) && $request->id) {
            $num_data->where('id', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(kode) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(nama) like '%" . strtolower($q) . "%'");
            });
            $num_data->where('poli_id', $request->poli_id);
        }
        $total_count = $num_data->count();
        $row_data = PoliSub::select('*');
        $row_data->where('stat', 'Aktif');

        if (isset($request->id) && $request->id) {
            $row_data->where('id', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(kode) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(nama) like '%" . strtolower($q) . "%'");
            });
            $row_data->where('poli_id', $request->poli_id);
        }

        $row_data->orderBy('kode', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharsePoliSub($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharsePoliSub($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->id,
                'text' => $value->nama,
                'kode' => $value->kode,
            );
        }
        return $res_array;
    }

    public function getDokter(Request $request)
    {
        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;

        $num_data = Pegawai::join('jenis_pegawai', 'jenis_pegawai.id', '=', 'pegawai.jenis_pegawai_id')
            ->select(['pegawai.id'])
            ->whereRaw("lower(jenis_pegawai.nama) = 'dokter'");

        if ($request->poli_id) {
            $num_data->where('pegawai.poli_id', $request->poli_id);
        }
        if (isset($request->id) && $request->id) {
            $num_data->where('pegawai.id', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(pegawai.kode) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(pegawai.nama) like '%" . strtolower($q) . "%'");
            });
        }
        $total_count = $num_data->count();
        $row_data = Pegawai::join('jenis_pegawai', 'jenis_pegawai.id', '=', 'pegawai.jenis_pegawai_id')
            ->select([
                'pegawai.*',
                DB::raw('jenis_pegawai.nama AS jenis_pegawai')
            ])
            ->whereRaw("lower(jenis_pegawai.nama) = 'dokter'");

        if (isset($request->id) && $request->id) {
            $row_data->where('pegawai.id', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(pegawai.kode) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(pegawai.nama) like '%" . strtolower($q) . "%'");
            });
        }

        if ($request->poli_id) {
            $row_data->where('pegawai.poli_id', $request->poli_id);
        }

        $row_data->orderBy('pegawai.kode', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharseDokter($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharseDokter($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->id,
                'text' => $value->nama,
            );
        }
        return $res_array;
    }

    public function getPoliRegistrasi(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $table = Registrasi::with(['pasien', 'pegawai', 'poli'])->select([
            'registrasi.*',
        ]);
        $table->whereRaw("( date_format(registrasi.tgl_daftar, '%Y-%m-%d') BETWEEN '" . dateconvert($request->tgl_mulai) . "' AND '" . dateconvert($request->tgl_selesai) . "' )");
        $table->where("registrasi.poli_id", $request->poli_id);
        $table->where("registrasi.stat_kunjungan", 'Konfirmasi');
        $table->where("registrasi.pegawai_id", Auth::user()->pegawai_id);
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                if (!$data->tgl_batal) {
                    $btn = '<center>' .
                        '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                        '<a href="' . url('/assesment/poli-' . strtolower($data->poli->kode) . '?id=' . $data->id . '&booking=' . $data->kode_booking) . '" class="btn btn-primary btn-sm">' .
                        'Pilih' .
                        '</a>' .
                        '</div>' .
                        '</center>';
                    return $btn;
                } else {
                    return 'Dibatalkan' .
                        '<br><small>' . $data->keterangan_batal . '</small>';
                }
            })
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function getKasir(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $table = Registrasi::with(['pasien', 'pegawai', 'poli'])->select([
            'registrasi.*',
        ]);
        $table->whereRaw("( date_format(registrasi.tgl_daftar, '%Y-%m-%d') BETWEEN '" . dateconvert($request->tgl_mulai) . "' AND '" . dateconvert($request->tgl_selesai) . "' )");
        $table->whereIn("registrasi.stat_kunjungan", ['Pemeriksaan', 'Selesai']);
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                if (!$data->tgl_batal) {
                    if ($data->stat_kunjungan =='Pemeriksaan') {
                        $btn = '<center>' .
                            '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                            '<a href="' . url('/kasir/bayar?id=' . $data->id . '&booking=' . $data->kode_booking) . '" class="btn btn-info btn-sm">' .
                            'Bayar' .
                            '</a>' .
                            '</div>' .
                            '</center>';
                    } else {
                        $btn = '<center>' .
                            '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                            '<a href="' . url('/kasir/bayar?id=' . $data->id . '&booking=' . $data->kode_booking) . '" class="btn btn-primary btn-sm">' .
                            'Edit' .
                            '</a>' .
                            '<a target="_blank" href="' . url('/kasir/print?id=' . $data->id . '&booking=' . $data->kode_booking) . '" class="btn btn-success btn-sm">' .
                            'Cetak' .
                            '</a>' .
                            '</div>' .
                            '</center>';
                    }
                    return $btn;
                } else {
                    return 'Dibatalkan' .
                        '<br><small>' . $data->keterangan_batal . '</small>';
                }
            })
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function getTindakan(Request $request)
    {

        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;


        $num_data = Tindakan::select(['id']);


        if (isset($request->id) && $request->id) {
            $num_data->where('id', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(kode) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(nama) like '%" . strtolower($q) . "%'");
            });
        }
        $total_count = $num_data->count();
        $row_data = Tindakan::select('*');

        if (isset($request->id) && $request->id) {
            $row_data->where('id', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(kode) like '%" . strtolower($q) . "%'")
                    ->orWhereRaw("lower(nama) like '%" . strtolower($q) . "%'");
            });
        }

        $row_data->orderBy('nama', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharseTindakan($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharseTindakan($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->id,
                'text' => $value->nama,
            );
        }
        return $res_array;
    }

    public function getBarangJenis(Request $request)
    {

        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;


        $num_data = BarangJenis::select(['id']);


        if (isset($request->id) && $request->id) {
            $num_data->where('id', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(nama) like '%" . strtolower($q) . "%'");
            });
        }
        $total_count = $num_data->count();
        $row_data = BarangJenis::select('*');

        if (isset($request->id) && $request->id) {
            $row_data->where('id', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(nama) like '%" . strtolower($q) . "%'");
            });
        }

        $row_data->orderBy('nama', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharseBarangJenis($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharseBarangJenis($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->id,
                'text' => $value->nama,
            );
        }
        return $res_array;
    }


    public function getBarangKategori(Request $request)
    {

        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;


        $num_data = BarangKategori::select(['id']);


        if (isset($request->id) && $request->id) {
            $num_data->where('id', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(nama) like '%" . strtolower($q) . "%'");
            });
        }
        $total_count = $num_data->count();
        $row_data = BarangKategori::select('*');

        if (isset($request->id) && $request->id) {
            $row_data->where('id', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(nama) like '%" . strtolower($q) . "%'");
            });
        }

        $row_data->orderBy('nama', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharseBarangKategori($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharseBarangKategori($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->id,
                'text' => $value->nama,
            );
        }
        return $res_array;
    }

    public function getBarangSatuan(Request $request)
    {

        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;


        $num_data = BarangSatuan::select(['id']);


        if (isset($request->id) && $request->id) {
            $num_data->where('satuan', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(satuan) like '%" . strtolower($q) . "%'");
            });
        }
        $total_count = $num_data->count();
        $row_data = BarangSatuan::select('*');

        if (isset($request->id) && $request->id) {
            $row_data->where('satuan', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(satuan) like '%" . strtolower($q) . "%'");
            });
        }

        $row_data->orderBy('satuan', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharseBarangSatuan($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharseBarangSatuan($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->satuan,
                'text' => $value->satuan,
            );
        }
        return $res_array;
    }

    public function getBarang(Request $request)
    {

        $d_arr = [];
        $incomplete_results = false;
        $q = (isset($request->q)) ? $request->q : '';
        $limit =  (isset($request->limit)) ? $request->limit : '5';
        $page = (isset($request->page)) ? $request->page : '1';

        $offset = ($page - 1) * $limit;

        $num_data = Barang::join('barang_kategori', 'barang_kategori.id', '=', 'barang.barang_kategori_id')
            ->select(['barang.id']);

        if ($request->kategori) {
            $num_data->where('barang_kategori.nama', $request->kategori);
        }

        if (isset($request->id) && $request->id) {
            $num_data->where('barang.id', $request->id);
        } else {
            $num_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(barang.nama) like '%" . strtolower($q) . "%'")
                    ->whereRaw("lower(barang.kode) like '%" . strtolower($q) . "%'");
            });
        }
        $total_count = $num_data->count();
        $row_data = Barang::join('barang_kategori', 'barang_kategori.id', '=', 'barang.barang_kategori_id')
            ->select(['barang.*']);

        if ($request->kategori) {
            $row_data->where('barang_kategori.nama', $request->kategori);
        }
        if (isset($request->id) && $request->id) {
            $row_data->where('barang.id', $request->id);
        } else {
            $row_data->where(function ($query) use ($q) {
                $query->whereRaw("lower(barang.nama) like '%" . strtolower($q) . "%'")
                    ->whereRaw("lower(barang.kode) like '%" . strtolower($q) . "%'");
            });
        }

        $row_data->orderBy('barang.nama', 'ASC');
        $row_data->offset($offset)->limit($limit);

        $items = $row_data->get();
        if (count($items) > 0) {
            $d_arr = $this->pharseBarang($items);
            $incomplete_results = true;
        }
        $data = array(
            'total_count' => $total_count,
            'incomplete_results' => $incomplete_results,
            'results' => $d_arr,
        );

        return json_encode($data);
    }

    protected function pharseBarang($items)
    {
        $res_array = [];
        foreach ($items as $value) {
            $res_array[] = array(
                'id' => $value->id,
                'text' => $value->nama,
                'satuan' => $value->satuan,
            );
        }
        return $res_array;
    }
}
