<?php

namespace App\Http\Controllers;

use App\CustomClass\CodeGenerator;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Registrasi;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegistrasiController extends Controller
{
    //
    protected $message = 'Data berhasil di proses';
    protected $res_code = 200;
    protected $response = array();

    public function __construct()
    {
        $this->middleware('auth');
        $this->stat = [
            'Aktif',
            'Tidak',
        ];
    }

    public function index()
    {
        return view('transaksi.registrasi.index', [
            'url' => url('/registrasi/insertData'),
            'stat' => $this->stat,
        ]);
    }

    public function insertData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'pasien_id'     => 'required',
                'poli_id'    => 'required',
                'pegawai_id'    => 'required',
                'keluhan'       => 'required',
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
            $bl = Registrasi::where('pasien_id', $request->pasien_id)
                        ->where('stat_kunjungan','<>','Batal')
                        ->first();

            if ($request->id) {
                $exist = Registrasi::where('id', $request->id)->first();
                if($exist->pegawai_id == $request->pegawai_id){
                    $dokter_urut = $request->dokter_urut;
                }else{
                    $dokter_urut = getUrutDokter($request->pegawai_id,  date('Y-m-d'));
                }
                Registrasi::where('id', $request->id)->update([
                    'pasien_id'         => $request->pasien_id,
                    'poli_id'           => $request->poli_id,
                    'pegawai_id'        => $request->pegawai_id,
                    'dokter_urut'       => $dokter_urut,
                    'keluhan'           => $request->keluhan,
                    'stat_kunjungan'    => 'Konfirmasi',
                    'user_id'           => Auth::user()->id,
                ]);
                $this->message = "Data berhasil diubah";
            } else {
                $exist = Registrasi::where('tgl_kunjungan', date('Y-m-d'))
                    ->where('pasien_id', $request->pasien_id)
                    ->where('pegawai_id', $request->pegawai_id)
                    ->whereNull('tgl_batal')
                    ->first();
                if ($exist) {
                    throw new Exception("Pasien ini sudah mendaftar dokter yang sama. Silahkan lakukan pembatalan terlebih dahulu.");
                }

                $this->response = Registrasi::create([
                    'kode'              => CodeGenerator::generateCodeRegistrasi(),
                    'kode_booking'      => CodeGenerator::generateCodeBooking(),
                    'tgl_kunjungan'     => date('Y-m-d'),
                    'tgl_daftar'        => date('Y-m-d H:i:s'),
                    'pasien_id'         => $request->pasien_id,
                    'poli_id'           => $request->poli_id,
                    'pegawai_id'        => $request->pegawai_id,
                    'dokter_urut'       => getUrutDokter($request->pegawai_id,  date('Y-m-d')),
                    'keluhan'           => $request->keluhan,
                    'pasien_baru'       => ($bl) ? 'Lama' : 'Baru',
                    'stat_kunjungan'    => 'Konfirmasi',
                    'user_id'           => Auth::user()->id,
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

    public function batalRegistrasi(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'id'                => 'required',
                'keterangan_batal'  => 'required',
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
            $this->response = Registrasi::where('id', $request->id)
                ->update([
                    'stat_kunjungan'    => 'Batal',
                    'keterangan_batal'  => $request->keterangan_batal,
                    'tgl_batal'         => date('Y-m-d H:i:s'),
                    'user_id'           => Auth::user()->id,
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

    public function tableMain(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $table = Registrasi::with(['pasien', 'pegawai', 'poli'])->select([
            'registrasi.*',
        ]);
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                if (!$data->tgl_batal) {
                    if(in_array($data->stat_kunjungan,['Reservasi', 'Konfirmasi'])){
                        $btn = '<center>' .
                        '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                        '<button class="btn btn-info btn-sm btn-edit">' .
                        'Edit' .
                        '</button>' .
                        '<button class="btn btn-danger btn-sm"' .
                        ' onclick="batalRegistrasi(\'' . $data->id . '\');">' .
                        'Batal' .
                        '</button>' .
                        '</div>' .
                        '</center>';
                    }else{
                        return '';
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

    public function riwayat(Request $request){
        if (!$request->ajax()) {
            return redirect('');
        }
        $id = explode('-',$request->id);
        if(is_array($id)){
            $pasien = Pasien::where('id', $id[0])->first();
            return view('transaksi.registrasi.formRiwayat', [
                'pasien' => $pasien,
                'registrasi_id' => $id[1],
            ]);
        }else{
            return '';
        }
    }

    public function tableRiwayat(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $table = Registrasi::with(['pasien', 'pegawai', 'poli'])
        ->whereNull('tgl_batal')
        ->where('pasien_id', $request->riwayat_pasien_id)
        ->select([
            'registrasi.*',
        ]);

        if($request->riwayat_registrasi_id){
            $table->where('id', '<>', $request->riwayat_registrasi_id);
        }
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-success btn-sm btn-preview">' .
                    'Preview' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                    
                    return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }
}
