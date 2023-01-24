<?php

namespace App\Http\Controllers;

use App\CustomClass\CodeGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Asuransi;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Validation\Rule;

class AsuransiController extends Controller
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
        return view('master.asuransi.index', []);
    }

    public function formAdd(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        return view('master.asuransi.form', [
            'url' => url('/asuransi/insertData'),
            'stat' => $this->stat,
        ]);
    }

    public function formEdit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Asuransi::where('id', $request->id)->first();
        return view('master.asuransi.form', [
            'url' => url('/asuransi/updateData'),
            'stat' => $this->stat,
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
                'nama_asuransi' => 'required|string',
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

            $this->response = Asuransi::create([
                'kode'          => CodeGenerator::generateCodeAsuransi(),
                'nama'          => $request->nama_asuransi,
                'stat'          => $request->stat_asuransi,
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

    public function updateData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'nama_asuransi' => ['required', 'string', 'max:255'],
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

            $this->response = Asuransi::where('id', '=', $request->id_asuransi)->update([
                'nama'          => $request->nama_asuransi,
                'stat'          => $request->stat_asuransi,
            ]);

            $this->message = "Data berhasil diupdate";
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
            $this->response = Asuransi::where('id', '=', $request->id)->delete();
            $this->message = "Data berhasil dihapus";
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
        $table = Asuransi::select([
            'kode',
            'nama',
            'stat',
            'id',
        ]);
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                if(in_array($data->nama, ['Umum','BPJS'])){
                    $btn = '';
                }else{
                    $btn = '<center>' .
                        '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                        '<button class="btn btn-info btn-sm"' .
                        ' data-bs-toggle="modal"' .
                        ' data-title="Edit Data : ' . $data->nama . '"' .
                        ' data-post-id="' . $data->id . '"' .
                        ' data-action-url="asuransi/formEdit/"' .
                        ' data-bs-target="#form-modal">' .
                        'Edit' .
                        '</button>' .
                        '<button class="btn btn-danger btn-sm"' .
                        ' onclick="deleteData(\'' . $data->id . '\');">' .
                        'Hapus' .
                        '</button>' .
                        '</div>' .
                        '</center>';
                }
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }
}
