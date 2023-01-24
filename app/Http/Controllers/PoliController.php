<?php

namespace App\Http\Controllers;

use App\CustomClass\CodeGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Poli;
use App\Models\PoliSub;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Validation\Rule;

class PoliController extends Controller
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
        return view('master.poli.index', []);
    }

    public function formAdd(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        return view('master.poli.form', [
            'url' => url('/poli/insertData'),
            'stat' => $this->stat,
        ]);
    }

    public function formEdit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Poli::where('id', $request->id)->first();
        return view('master.poli.form', [
            'url' => url('/poli/updateData'),
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
                'nama' => 'required|string|unique:poli',
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

            $this->response = Poli::create([
                'kode'          => $request->kode,
                'kode_sms'      => $request->kode_sms,
                'nama'          => $request->nama,
                'stat'          => $request->stat,
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
                'kode' => ['required', 'string', 'max:10', Rule::unique('poli')->ignore($request->id)],
                'nama' => ['required', 'string', 'max:255', Rule::unique('poli')->ignore($request->id)],
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

            $this->response = Poli::where('id', '=', $request->id)->update([
                'kode_sms'      => ($request->kode),
                'nama'          => $request->nama,
                'stat'          => $request->stat,
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
            $this->response = Poli::where('id', '=', $request->id)->delete();
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
        $table = Poli::select([
            'kode',
            'kode_sms',
            'nama',
            'stat',
            'id',
        ]);
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-success btn-sm"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Sub Spesialis Data : ' . $data->nama . '"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="poli/formSubSpesialis/"' .
                    ' data-bs-target="#form-modal">' .
                    'Sub Spesialis' .
                    '</button>' .

                    '<button class="btn btn-info btn-sm"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data : ' . $data->nama . '"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="poli/formEdit/"' .
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

    // Sub Spesialis
    public function formSubSpesialis(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }

        return view('master.poli.formSubSpesialis', [
            'url' => url('/poli/submitSubSpesialis'),
            'stat' => $this->stat,
            'poli_id' => $request->id,
        ]);
    }

    public function tableDetail(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $table = PoliSub::where('poli_id', $request->poli_id)
        ->select([
            'poli_sub.poli_id',
            'poli_sub.kode',
            'poli_sub.nama',
            'poli_sub.stat',
            'poli_sub.id',
        ]);
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-info btn-sm btn-edit-detail">' .
                    'Edit' .
                    '</button>' .

                    '<button class="btn btn-danger btn-sm btn-delete-detail">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function submitSubSpesialis(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|unique:poli',
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
            $exist = PoliSub::where('id', $request->id)->first();
            if($exist){
                $this->response = PoliSub::where('id', $request->id)
                ->update([
                    'kode'          => $request->kode,
                    'nama'          => $request->nama,
                    'stat'          => $request->stat,
                ]);
                $this->message = "Data berhasil diupdate";
            }else{
                $this->response = PoliSub::create([
                    'kode'          => $request->kode,
                    'nama'          => $request->nama,
                    'stat'          => $request->stat,
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

    public function deleteSubSpesialis(Request $request)
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
            $this->response = PoliSub::where('id', '=', $request->id)->delete();
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
}
