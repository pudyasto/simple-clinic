<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Poli;
use App\Models\PoliPenunjang;
use App\Models\PoliResep;
use App\Models\PoliTindakan;
use App\Models\PoliUmum;
use App\Models\Registrasi;
use App\Models\Tindakan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PoliUmumController extends Controller
{
    //
    protected $message = 'Data berhasil di proses';
    protected $res_code = 200;
    protected $response = array();

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $poli = Poli::where('kode', 'UMU')->first();
        return view('transaksi.poliumum.index', [
            'poli' => $poli,
        ]);
    }

    // Tindakan Start
    public function submitTindakan(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'tindakan_id'     => 'required',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->res_code = 201;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->res_code,
                    ),
                    'response' => $errors,
                ], 200);
            }

            DB::beginTransaction();
            $registrasi = Registrasi::where('id', $request->registrasi_id)->first();
            if (!$registrasi) {
                throw new Exception("Data registrasi tidak valid!");
            }
            $tindakan = Tindakan::where('id', $request->tindakan_id)->first();
            if (!$tindakan) {
                throw new Exception("Data tidakan tidak tersedia!");
            }

            $exist = PoliTindakan::where('registrasi_id', $request->registrasi_id)
                ->where('tindakan_id', $request->tindakan_id)
                ->first();
            if ($exist) {
                throw new Exception("Tindakan tidak boleh sama!");
            }

            if ($request->poli_tindakan_id) {
                PoliTindakan::where('id', $request->poli_tindakan_id)->update([
                    'registrasi_id' => $registrasi->id,
                    'poli_id'       => $registrasi->poli_id,
                    'pegawai_id'    => $registrasi->pegawai_id,
                    'pasien_id'     => $registrasi->pasien_id,

                    'tindakan_id'   => $tindakan->id,
                    'icd9'          => $tindakan->icd9,
                    'nama'          => $tindakan->nama,
                    'tarif'         => $tindakan->tarif,
                ]);
                $this->message = "Data berhasil diubah";
            } else {
                $this->response = PoliTindakan::create([
                    'registrasi_id' => $registrasi->id,
                    'poli_id'       => $registrasi->poli_id,
                    'pegawai_id'    => $registrasi->pegawai_id,
                    'pasien_id'     => $registrasi->pasien_id,

                    'tindakan_id'   => $tindakan->id,
                    'icd9'          => $tindakan->icd9,
                    'nama'          => $tindakan->nama,
                    'tarif'         => $tindakan->tarif,
                ]);
                $this->message = "Data berhasil disimpan";
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->res_code = 201;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->res_code,
            ),
            'response' => $this->response,
        ], 200);
    }

    public function deleteDataTindakan(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'id'     => 'required',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->res_code = 201;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->res_code,
                    ),
                    'response' => $errors,
                ], 200);
            }

            DB::beginTransaction();
            PoliTindakan::where('id', $request->id)->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->res_code = 201;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->res_code,
            ),
            'response' => $this->response,
        ], 200);
    }

    public function tableTindakan(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $table = PoliTindakan::with(['tindakan'])
                    ->where('registrasi_id', $request->registrasi_id)
        ->select([
            'poli_tindakan.*',
        ]);
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button type="button" class="btn btn-info btn-sm btn-edit-tindakan">' .
                    'Edit' .
                    '</button>' .
                    '<button type="button" class="btn btn-danger btn-sm btn-hapus-tindakan">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }
    // Tindakan End

    // Barang Start
    public function submitBarang(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'barang_id'     => 'required',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->res_code = 201;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->res_code,
                    ),
                    'response' => $errors,
                ], 200);
            }

            DB::beginTransaction();
            $registrasi = Registrasi::where('id', $request->registrasi_id)->first();
            if (!$registrasi) {
                throw new Exception("Data registrasi tidak valid!");
            }
            $barang = Barang::where('id', $request->barang_id)->first();
            if (!$barang) {
                throw new Exception("Data Barang tidak tersedia!");
            }

            $exist = PoliResep::where('registrasi_id', $request->registrasi_id)
                ->where('barang_id', $request->barang_id)
                ->first();
            if ($exist && !$request->poli_resep_id) {
                throw new Exception("Barang tidak boleh sama!");
            }

            if ($request->poli_resep_id) {
                PoliResep::where('id', $request->poli_resep_id)->update([
                    'registrasi_id' => $registrasi->id,
                    'poli_id'       => $registrasi->poli_id,
                    'pegawai_id'    => $registrasi->pegawai_id,
                    'pasien_id'     => $registrasi->pasien_id,

                    'barang_id'     => $barang->id,
                    'qty'           => $request->qty,
                    'harga_jual'    => $request->qty * $barang->harga_jual,
                ]);
                $this->message = "Data berhasil diubah";
            } else {
                $this->response = PoliResep::create([
                    'registrasi_id' => $registrasi->id,
                    'poli_id'       => $registrasi->poli_id,
                    'pegawai_id'    => $registrasi->pegawai_id,
                    'pasien_id'     => $registrasi->pasien_id,

                    'barang_id'     => $barang->id,
                    'qty'           => $request->qty,
                    'harga_jual'    => $request->qty * $barang->harga_jual,
                ]);
                $this->message = "Data berhasil disimpan";
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->res_code = 201;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->res_code,
            ),
            'response' => $this->response,
        ], 200);
    }

    public function deleteDataBarang(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'id'     => 'required',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->res_code = 201;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->res_code,
                    ),
                    'response' => $errors,
                ], 200);
            }

            DB::beginTransaction();
            PoliResep::where('id', $request->id)->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->res_code = 201;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->res_code,
            ),
            'response' => $this->response,
        ], 200);
    }

    public function tableBarang(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $table = PoliResep::with(['barang'])
        ->where('registrasi_id', $request->registrasi_id)
        ->select([
            'poli_resep.*',
        ]);
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button type="button" class="btn btn-info btn-sm btn-edit-barang">' .
                    'Edit' .
                    '</button>' .
                    '<button type="button" class="btn btn-danger btn-sm btn-hapus-barang">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }
    // Barang End

    // Penunjang Start
    public function submitPenunjang(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'nama_file'     => 'required',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->res_code = 201;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->res_code,
                    ),
                    'response' => $errors,
                ], 200);
            }

            DB::beginTransaction();
            $registrasi = Registrasi::where('id', $request->registrasi_id)->first();
            if (!$registrasi) {
                throw new Exception("Data registrasi tidak valid!");
            }
            $nama_file = $this->uploadFile($registrasi, $request);
            $this->response = PoliPenunjang::create([
                'registrasi_id' => $registrasi->id,
                'poli_id'       => $registrasi->poli_id,
                'pegawai_id'    => $registrasi->pegawai_id,
                'pasien_id'     => $registrasi->pasien_id,

                'nama_file'     => $nama_file,
            ]);
            $this->message = "Data berhasil disimpan";

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->res_code = 201;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->res_code,
            ),
            'response' => $this->response,
        ], 200);
    }

    private function uploadFile($registrasi, $request)
    {
        if ($request->hasFile('nama_file')) {

            $file_name = $registrasi->kode . '-' . $registrasi->pasien_id . '-' . date('YmdHis');
            $validator = Validator::make($request->all(), [
                'nama_file' => 'file|mimes:jpg,jpeg,bmp,png|max:10240',
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            array_map('unlink', glob(public_path('files/penunjang') . "/$file_name*"));
            $guessExtension = $request->file('nama_file')->guessExtension();
            $request->file('nama_file')->move('files/penunjang', $file_name . '.' . $guessExtension);
            return $file_name . '.' . $guessExtension;
        }
    }

    public function deleteDataPenunjang(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'id'     => 'required',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->res_code = 201;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->res_code,
                    ),
                    'response' => $errors,
                ], 200);
            }

            DB::beginTransaction();
            $penunjang = PoliPenunjang::where('id', $request->id)->first();
            array_map('unlink', glob(public_path('files/penunjang') . "/" . $penunjang->nama_file . "*"));
            PoliPenunjang::where('id', $request->id)->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->res_code = 201;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->res_code,
            ),
            'response' => $this->response,
        ], 200);
    }

    public function tablePenunjang(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $table = PoliPenunjang::where('registrasi_id', $request->registrasi_id)
        ->select([
            'poli_penunjang.*',
        ]);
        return DataTables::of($table)
            ->addColumn('img', function ($data) {
                $image = glob(public_path('files/penunjang') . "/" . $data->nama_file . "*");
                if (count($image) > 0) {
                    $path = $image[0];
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $dataImage = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
                    return '<a href="' . url('assesment/attachdata/?id=' . $data->id . '&registrasi_id=' . $data->registrasi_id) . '" target="blank"><img src="' . $base64 . '" class="img img-round" style="max-height: 100px;" alt="' . $data->id . '"/></a>';
                } else {
                    return null;
                }
            })
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button type="button" class="btn btn-danger btn-sm btn-hapus-barang">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['img', 'btn'])
            ->make(true);
    }
    // Penunjang End

    public function submitData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'fisik_td_mm'     => 'required',
                'fisik_td_hg'     => 'required',

                'fisik_nadi'     => 'required',
                'fisik_nafas'     => 'required',

                'fisik_suhu'     => 'required',
                'fisik_tb'     => 'required',
                'fisik_bb'     => 'required',

                'diagnosa_utama'     => 'required',
                'ringkasan'     => 'required',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->res_code = 201;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->res_code,
                    ),
                    'response' => $errors,
                ], 200);
            }

            DB::beginTransaction();
            $registrasi = Registrasi::where('id', $request->registrasi_id)->first();
            if (!$registrasi) {
                throw new Exception("Data registrasi tidak valid!");
            }
            Registrasi::where('id', $request->registrasi_id)->update([
                'stat_kunjungan' => 'Pemeriksaan'
            ]);
            $poli = PoliUmum::where('registrasi_id', $registrasi->id)->first();
            if ($poli) {
                $this->response = PoliUmum::where('id', $poli->id)->update([
                    'tgl_periksa'   => $registrasi->tgl_kunjungan,

                    'registrasi_id' => $registrasi->id,
                    'poli_id'       => $registrasi->poli_id,
                    'pegawai_id'    => $registrasi->pegawai_id,
                    'pasien_id'     => $registrasi->pasien_id,

                    'fisik_td'      => $request->fisik_td_mm . '/' . $request->fisik_td_hg,
                    'fisik_nadi'    => $request->fisik_nadi,
                    'fisik_nafas'   => $request->fisik_nafas,
                    'fisik_suhu'    => $request->fisik_suhu,
                    'fisik_tb'      => $request->fisik_tb,
                    'fisik_bb'      => $request->fisik_bb,

                    'ringkasan'             => $request->ringkasan,

                    'diagnosa_utama'        => $request->diagnosa_utama,
                    'ket_diagnosa_utama'    => '-',

                    'diagnosa_sekunder_1'   => $request->diagnosa_sekunder_1,
                    'diagnosa_sekunder_2'   => '-',
                    'ket_diagnosa_sekunder' => $request->ket_diagnosa_sekunder,
                ]);
            } else {
                $this->response = PoliUmum::create([
                    'tgl_periksa'   => $registrasi->tgl_kunjungan,

                    'registrasi_id' => $registrasi->id,
                    'poli_id'       => $registrasi->poli_id,
                    'pegawai_id'    => $registrasi->pegawai_id,
                    'pasien_id'     => $registrasi->pasien_id,

                    'fisik_td'      => $request->fisik_td_mm . '/' . $request->fisik_td_hg,
                    'fisik_nadi'    => $request->fisik_nadi,
                    'fisik_nafas'   => $request->fisik_nafas,
                    'fisik_suhu'    => $request->fisik_suhu,
                    'fisik_tb'      => $request->fisik_tb,
                    'fisik_bb'      => $request->fisik_bb,

                    'ringkasan'             => $request->ringkasan,

                    'diagnosa_utama'        => $request->diagnosa_utama,
                    'ket_diagnosa_utama'    => '-',

                    'diagnosa_sekunder_1'   => $request->diagnosa_sekunder_1,
                    'diagnosa_sekunder_2'   => '-',
                    'ket_diagnosa_sekunder' => $request->ket_diagnosa_sekunder,
                ]);
            }
            $this->message = "Data berhasil disimpan";

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->res_code = 201;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->res_code,
            ),
            'response' => $this->response,
        ], 200);
    }

    public function getRiwayatPoli(Request $request){
        $this->response = PoliUmum::with(['pasien',
        'diag_utama',
        'diag_sekunder_1',
        'diag_sekunder_2',
        'politindakan',
        'poliresep' => function ($q){
            $q->join('barang','barang.id','=','poli_resep.barang_id');
        },
        'polipenunjang',])
                            ->where('registrasi_id', $request->id)->first();

        $this->response->fisik_td_mm = '';
        $this->response->fisik_td_hg = '';
        if($this->response->fisik_td){
            $fisik_td = explode('/',$this->response->fisik_td);
            if(is_array($fisik_td)){
                $this->response->fisik_td_mm = $fisik_td[0];
                $this->response->fisik_td_hg = $fisik_td[1];
            }
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->res_code,
            ),
            'response' => $this->response,
        ], 200);
    }
}
