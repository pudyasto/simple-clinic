<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\PegawaiJenis;
use Exception;
use Yajra\DataTables\DataTables;

class PegawaiJenisController extends Controller
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
        return view('master.pegawai-jenis.index', []);
    }

    public function formAdd(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        return view('master.pegawai-jenis.form', [
            'url' => url('/pegawai-jenis/insertData'),
        ]);
    }

    public function formEdit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = PegawaiJenis::where('id', $request->id)->first();
        return view('master.pegawai-jenis.form', [
            'url' => url('/pegawai-jenis/updateData'),
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
                'nama_jenis_pegawai'     => 'required',
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

            $this->response = PegawaiJenis::create([
                'nama'    => $request->nama_jenis_pegawai,
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
                'id_jenis_pegawai'      => 'required|numeric',
                'nama_jenis_pegawai'    => 'required',
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

            $this->response = PegawaiJenis::where('id', '=', $request->id_jenis_pegawai)->update([
                'nama'    => $request->nama_jenis_pegawai,
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
                'id_jenis_pegawai' => 'required|string',
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
            $this->response = PegawaiJenis::where('id', '=', $request->id_jenis_pegawai)->delete();
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
        $data = PegawaiJenis::all();
        return DataTables::of($data)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-info btn-sm"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="pegawai-jenis/formEdit/"' .
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
