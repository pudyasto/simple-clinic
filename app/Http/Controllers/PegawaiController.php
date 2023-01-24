<?php

namespace App\Http\Controllers;

use App\CustomClass\CodeGenerator;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Pegawai;
use App\Models\PegawaiJenis;
use Exception;
use Yajra\DataTables\DataTables;

class PegawaiController extends Controller
{
    //
    protected $message = 'Data berhasil di proses';
    protected $code = 200;
    protected $response = array();

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.pegawai.index', []);
    }

    public function formAdd(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }

        return view('master.pegawai.form', [
            'url' => url('/pegawai/insertData'),
            'jenis_pegawai_id' => PegawaiJenis::all(),
            'cabang_id' => Cabang::all(),
        ]);
    }

    public function formEdit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Pegawai::where('id', $request->id)->first();
        return view('master.pegawai.form', [
            'url' => url('/pegawai/updateData'),
            'data' => $data,
            'jenis_pegawai_id' => PegawaiJenis::all(),
            'cabang_id' => Cabang::all(),
        ]);
    }

    public function insertData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'nama'     => 'required',
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

            $this->response = Pegawai::create([
                'kode'              => ($request->kode) ? $request->kode : CodeGenerator::generateKodePegawai(),
                'nama'              => $request->nama,
                'alamat'            => $request->alamat,
                'telp'              => $request->telp,
                'foto'              => $request->foto,
                'jenis_pegawai_id'  => $request->jenis_pegawai_id,
                'poli_id'           => $request->poli_id,
                'poli_sub_id'       => $request->poli_sub_id,
                'cabang_id'         => $request->cabang_id,
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
                'id'      => 'required|numeric',
                'nama'    => 'required',
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

            $this->response = Pegawai::where('id', '=', $request->id)->update([
                'kode'              => ($request->kode) ? $request->kode : CodeGenerator::generateKodePegawai(),
                'nama'              => $request->nama,
                'alamat'            => $request->alamat,
                'telp'              => $request->telp,
                'foto'              => $request->foto,
                'jenis_pegawai_id'  => $request->jenis_pegawai_id,
                'poli_id'           => $request->poli_id,
                'poli_sub_id'       => $request->poli_sub_id,
                'cabang_id'         => $request->cabang_id,
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
            $this->response = Pegawai::where('id', '=', $request->id)->delete();
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
        $data = Pegawai::with(['pegawaijenis'])->select(['pegawai.*']);
        return DataTables::of($data)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-info btn-sm"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="pegawai/formEdit/"' .
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
