<?php

namespace App\Http\Controllers;

use App\CustomClass\CodeGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Tindakan;
use Exception;
use Yajra\DataTables\DataTables;

class TindakanController extends Controller
{
    //
    protected $message = 'Data berhasil di proses';
    protected $code = 200;
    protected $response = array();
    protected $stat = ['Aktif','Tidak'];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.tindakan.index', []);
    }

    public function formAdd(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        return view('master.tindakan.form', [
            'url' => url('/tindakan/insertData'),
            'stat' => $this->stat,
        ]);
    }

    public function formEdit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Tindakan::where('id', $request->id)->first();
        return view('master.tindakan.form', [
            'url' => url('/tindakan/updateData'),
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
                'nama'     => 'required',
                'tarif'     => 'required|numeric',
                'stat'     => 'required',
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

            $this->response = Tindakan::create([
                'kode'  => CodeGenerator::generateKodeTindakan(),
                'icd9'  => $request->icd9,
                'nama'  => $request->nama,
                'tarif' => $request->tarif,
                'stat'  => $request->stat,
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
                'nama'     => 'required',
                'tarif'     => 'required|numeric',
                'stat'     => 'required',
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

            $this->response = Tindakan::where('id', '=', $request->id)->update([
                'icd9'  => $request->icd9,
                'nama'  => $request->nama,
                'tarif' => $request->tarif,
                'stat'  => $request->stat,
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
            $this->response = Tindakan::where('id', '=', $request->id)->delete();
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
        $data = Tindakan::all();
        return DataTables::of($data)
            ->addColumn('btn', function ($data) {
                // if(in_array($data->kode,['0001','0002'])){
                //     $btn = '<center>' .
                //         '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                //         '<button class="btn btn-info btn-sm"' .
                //         ' data-bs-toggle="modal"' .
                //         ' data-title="Edit Data"' .
                //         ' data-post-id="' . $data->id . '"' .
                //         ' data-action-url="tindakan/formEdit/"' .
                //         ' data-bs-target="#form-modal">' .
                //         'Edit' .
                //         '</button>' .
                //         '</div>' .
                //         '</center>';
                // }else{
                    $btn = '<center>' .
                        '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                        '<button class="btn btn-info btn-sm"' .
                        ' data-bs-toggle="modal"' .
                        ' data-title="Edit Data"' .
                        ' data-post-id="' . $data->id . '"' .
                        ' data-action-url="tindakan/formEdit/"' .
                        ' data-bs-target="#form-modal">' .
                        'Edit' .
                        '</button>' .
                        '<button class="btn btn-danger btn-sm"' .
                        ' onclick="deleteData(\'' . $data->id . '\');">' .
                        'Hapus' .
                        '</button>' .
                        '</div>' .
                        '</center>';
                // }
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }
}
