<?php

namespace App\Http\Controllers;

use App\CustomClass\CodeGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Cabang;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Validation\Rule;

class CabangController extends Controller
{
    //
    protected $message = 'Data berhasil di proses';
    protected $res_code = 200;
    protected $response = array();

    public function __construct()
    {
        $this->middleware('auth');
        $this->jenis_cabang = [
            'Pusat',
            'Cabang',
        ];
    }

    public function index()
    {
        return view('master.cabang.index', []);
    }

    public function formAdd(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        return view('master.cabang.form', [
            'url' => url('/cabang/insertData'),
            'jenis_cabang' => $this->jenis_cabang,
        ]);
    }

    public function formEdit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Cabang::where('id', $request->id)->first();
        return view('master.cabang.form', [
            'url' => url('/cabang/updateData'),
            'jenis_cabang' => $this->jenis_cabang,
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
                'nama' => 'required|string',
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

            $this->response = Cabang::create([
                'kode'      => CodeGenerator::generateCodeCabang(),
                'nama'      => $request->nama,
                'alamat'    => $request->alamat,

                'prov_id'=> $request->prov_id,
                'kota_id'=> $request->kota_id,
                'kec_id'=> $request->kec_id,
                'kel_id'=> $request->kel_id,
        
                'no_telp'=> $request->no_telp,
                'email'=> $request->email,
                'jenis_cabang'=> $request->jenis_cabang,
        
                'main_id'=> $request->main_id,
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
                'nama' => ['required', 'string', 'max:255'],
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

            $this->response = Cabang::where('id', '=', $request->id)->update([
                'nama'      => $request->nama,
                'alamat'    => $request->alamat,

                'prov_id'=> $request->prov_id,
                'kota_id'=> $request->kota_id,
                'kec_id'=> $request->kec_id,
                'kel_id'=> $request->kel_id,
        
                'no_telp'=> $request->no_telp,
                'email'=> $request->email,
                'jenis_cabang'=> $request->jenis_cabang,
        
                'main_id'=> $request->main_id,
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
            $this->response = Cabang::where('id', '=', $request->id)->delete();
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
        $table = Cabang::select([
            '*',
        ]);
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                    $btn = '<center>' .
                        '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                        '<button class="btn btn-info btn-sm"' .
                        ' data-bs-toggle="modal"' .
                        ' data-title="Edit Data : ' . $data->nama . '"' .
                        ' data-post-id="' . $data->id . '"' .
                        ' data-action-url="cabang/formEdit/"' .
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
