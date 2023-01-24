<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

use App\Models\User;
use Exception;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    protected $message = 'Data berhasil di proses';
    protected $code = 200;
    protected $response = array();
    protected $data = array();

    public function __construct()
    {
        $this->middleware('auth');
        $this->data['is_active'] = [
            '1' => 'Aktif',
            '0' => 'Tidak',
        ];
    }

    public function index()
    {
        return view('rbac.user.index', []);
    }

    public function formAdd(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }

        return view('rbac.user.form', [
            'url' => url('/user/insertData'),
            'is_active' => $this->data['is_active'],
            'pegawai_id' => Pegawai::all(),
        ]);
    }

    public function formEdit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = User::where('id', $request->id)->first();
        return view('rbac.user.form', [
            'url' => url('/user/updateData'),
            'is_active' => $this->data['is_active'],
            'pegawai_id' => Pegawai::all(),
            'data' => $data,
        ]);
    }

    public function tableMain(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $table = User::with(['groups'])->select(['users.*']);
        return DataTables::of($table)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-info btn-sm"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data : ' . $data->name . '"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="user/formEdit/"' .
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

    public function getUserGroup(Request $request)
    {
        $group = Groups::all();
        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $group,
        ], $this->code);
    }

    public function insertData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'group_id' => ['required', 'numeric'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'username' => ['required', 'string', 'max:20', 'unique:users'],
                'password' => ['required', 'string', 'min:4'],
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
            // throw new Exception($request->unit_id);
            DB::beginTransaction();

            $this->response = User::create([
                'email_verified_at' => date('Y-m-d H:i:s'),
                'name'              => $request->name,
                'username'          => $request->username,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'group_id'          => $request->group_id,
                'pegawai_id'        => $request->pegawai_id,
                
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
                'id'        => ['required', 'numeric'],
                'name'      => ['required', 'string', 'max:255'],
                'group_id'  => ['required', 'numeric'],

                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($request->id)],
                'username' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($request->id)],
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

            $this->response = User::where('id', '=', $request->id)->update([
                'name'      => $request->name,
                'group_id'  => $request->group_id,
                'email'     => $request->email,
                'username'  => $request->username,
                'pegawai_id'        => $request->pegawai_id,
            ]);

            if (isset($request->password) && $request->password) {
                User::where('id', '=', $request->id)->update([
                    'password' => Hash::make($request->password),
                ]);
            }

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
            $this->response = User::where('id', '=', $request->id)->delete();
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
}
