<?php

namespace App\Http\Controllers;

use App\CustomClass\CodeGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Pasien;
use Exception;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PasienController extends Controller
{
    //
    protected $message = 'Data berhasil di proses';
    protected $code = 200;
    protected $response = array();

    protected $jenis_kelamin = [
        'Laki-Laki',
        'Perempuan',
    ];
    
    protected $agama = [
        'Islam',
        'Kristen Protestan',
        'Kristen Katolik',
        'Hindu',
        'Buddha',
        'Khonghucu',
    ];

    protected $gol_darah = [
        'Tidak Tahu',
        'A',
        'B',
        'AB',
        'O',
    ];

    protected $pekerjaan = [
        "Belum Bekerja" ,
        "TNI / POLRI",
        "PNS",
        "Karyawan Swasta",
        "Guru",
        "Dosen",
        "Dokter / Tenaga Medis",
        "Wiraswasta",
        "Buruh",
        "Petani",
        "Nelayan",
        "Pelajar / Mahasiswa",
        "Legislatif",
        "Lain-Lain",
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.pasien.index', []);
    }

    public function formAdd(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        return view('master.pasien.form', [
            'url' => url('/pasien/insertData'),
            'jenis_kelamin' => $this->jenis_kelamin,
            'gol_darah' => $this->gol_darah,
            'agama' => $this->agama,
            'pekerjaan' => $this->pekerjaan,
            'prov_id' => DB::table('provinsi')->get(),
        ]);
    }

    public function formEdit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Pasien::where('id', $request->id)->first();
        return view('master.pasien.form', [
            'url' => url('/pasien/updateData'),
            'jenis_kelamin' => $this->jenis_kelamin,
            'gol_darah' => $this->gol_darah,
            'agama' => $this->agama,
            'pekerjaan' => $this->pekerjaan,
            'prov_id' => DB::table('provinsi')->get(),
            'data' => $data,
        ]);
    }

    public function insertData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'nama_pasien'   => 'required',
                'tgl_lahir'     => 'required|max:10',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->code = 202;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->code,
                    ),
                    'response' => $errors,
                ], $this->code);
            }
            DB::beginTransaction();
            // throw new Exception(CodeGenerator::generateKodePasien($request->nama_pasien));
            // die;
            $this->response = Pasien::create([
                'no_rm'             => CodeGenerator::generateKodePasien($request->nama_pasien),
                'nama_pasien'       => $request->nama_pasien,
                'no_identitas'      => $request->no_identitas, 
                'asuransi_id'       => $request->asuransi_id, 
                'no_asuransi'       => $request->no_asuransi, 
                'tgl_lahir'         => dateconvert($request->tgl_lahir), 
                'tmp_lahir'         => $request->tmp_lahir, 
                'jenis_kelamin'     => $request->jenis_kelamin, 
                'agama'             => $request->agama, 
                'pekerjaan'         => $request->pekerjaan, 
                'gol_darah'         => $request->gol_darah, 
                'pendidikan'        => $request->pendidikan, 
                'alamat'            => $request->alamat, 
                'prov_id'           => $request->prov_id, 
                'kota_id'           => $request->kota_id, 
                'kec_id'            => $request->kec_id, 
                'kel_id'            => $request->kel_id, 
                'no_telp'           => $request->no_telp, 
                'email'             => $request->email, 
                'alergi'            => $request->alergi, 
                'penyakit'          => $request->penyakit, 
                'foto'              => $request->foto, 
                'user_id'           => Auth::user()->id,
            ]);

            $this->message = "Data berhasil disimpan";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 202;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    public function updateData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'nama_pasien'   => 'required',
                'tgl_lahir'     => 'required|max:10',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->code = 202;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->code,
                    ),
                    'response' => $errors,
                ], $this->code);
            }
            DB::beginTransaction();

            $this->response = Pasien::where('id', '=', $request->id)->update([
                'nama_pasien'       => $request->nama_pasien,
                'no_identitas'      => $request->no_identitas, 
                'asuransi_id'       => $request->asuransi_id, 
                'no_asuransi'       => $request->no_asuransi, 
                'tgl_lahir'         => dateconvert($request->tgl_lahir), 
                'tmp_lahir'         => $request->tmp_lahir, 
                'jenis_kelamin'     => $request->jenis_kelamin, 
                'agama'             => $request->agama, 
                'pekerjaan'         => $request->pekerjaan, 
                'gol_darah'         => $request->gol_darah, 
                'pendidikan'        => $request->pendidikan, 
                'alamat'            => $request->alamat, 
                'prov_id'           => $request->prov_id, 
                'kota_id'           => $request->kota_id, 
                'kec_id'            => $request->kec_id, 
                'kel_id'            => $request->kel_id, 
                'no_telp'           => $request->no_telp, 
                'email'             => $request->email, 
                'alergi'            => $request->alergi, 
                'penyakit'          => $request->penyakit, 
                'foto'              => $request->foto, 
                'user_id'           => Auth::user()->id,
            ]);

            $this->message = "Data berhasil diupdate";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 202;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    public function deleteData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'id' => 'required|string',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->code = 202;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->code,
                    ),
                    'response' => $errors,
                ], $this->code);
            }
            DB::beginTransaction();
            $this->response = Pasien::where('id', '=', $request->id)->delete();
            $this->message = "Data berhasil dihapus";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 202;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    public function tableMain(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Pasien::all();
        return DataTables::of($data)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-info btn-sm"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="pasien/formEdit/"' .
                    ' data-bs-target="#form-modal">' .
                    'Edit' .
                    '</button>' .
                    '<button class="btn btn-danger btn-sm"' .
                    ' onclick="deleteData(\'' . $data->id . '\');">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }
}
