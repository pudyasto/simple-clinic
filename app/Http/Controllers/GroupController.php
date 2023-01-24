<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Groups;
use App\Models\GroupsAccess;
use Yajra\DataTables\DataTables;
use Exception;

class GroupController extends Controller
{
    //
    protected $message = 'Data berhasil di proses';
    protected $code = 200;
    protected $response = array();
    protected $data = array();

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('rbac.group.index', []);
    }

    public function formAdd(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        return view('rbac.group.form', [
            'url' => url('/group/insertData'),
        ]);
    }

    public function formEdit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Groups::where('id', $request->id)->first();
        return view('rbac.group.form', [
            'url' => url('/group/updateData'),
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
                'name' => 'required|string|unique:groups',
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

            $this->response = Groups::create([
                'name'     => $request->name,
                'description'   => $request->description,
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
                'id' => 'required|numeric',
                'name' => 'required|string',
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

            $this->response = Groups::where('id', '=', $request->id)->update([
                'name'     => $request->name,
                'description'   => $request->description,
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
            throw new Exception("Testing");
            DB::beginTransaction();
            $this->response = Groups::where('id', '=', $request->id)->delete();
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
        $data = Groups::all();
        return DataTables::of($data)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-success btn-sm"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Set Hak Akses : ' . $data->name . '"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="group/formPrivilege/"' .
                    ' data-bs-target="#form-modal">' .
                    'Akses' .
                    '</button>' .
                    '<button class="btn btn-info btn-sm"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="group/formEdit/"' .
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

    // Group Access Start
    public function formPrivilege(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }

        $groups = Groups::where('id', $request->id)->first();
        return view('rbac.group.formPrivilege', [
            'data' => $groups,
        ]);
    }

    public function tablePrivilege(Request $request)
    {
        $get = $request->input();

        $table = " SELECT set_access, menu_name, submenu, description, id, privilege  FROM (
                    SELECT 
                        a.menu_name,
                        b.menu_name AS submenu,
                        b.description,
                        b.id,
                        (SELECT 
                                group_id
                            FROM
                                groups_access AS tg
                            WHERE
                                group_id = '" . $get['group_id'] . "' AND (menu_id = b.id)) AS set_access,
                            (SELECT 
                                privilege
                            FROM
                                groups_access AS tg
                            WHERE
                                group_id = '" . $get['group_id'] . "' AND (menu_id = b.id)) AS privilege
                    FROM
                        menus AS a
                            INNER JOIN
                        menus AS b ON a.id = b.main_id 
                    UNION ALL 
                    SELECT 
                        a.menu_name,
                        '' AS submenu,
                        a.description,
                        a.id,
                        (SELECT 
                                group_id
                            FROM
                                groups_access AS tg
                            WHERE
                                group_id = '" . $get['group_id'] . "' AND (menu_id = a.id)) AS set_access,
                            (SELECT 
                                privilege
                            FROM
                                groups_access AS tg
                            WHERE
                                group_id = '" . $get['group_id'] . "' AND (menu_id = a.id)) AS privilege
                    FROM
                        menus AS a
                    WHERE
                    a.link <> '#' AND a.main_id IS NULL
                    ) tran_group ";
        $data  = DB::select(DB::raw($table));

        return DataTables::of($data)
            ->addColumn('set_access', function ($data) {
                if ($data->set_access) {
                    $btn = '<center>' .
                        '<button class="btn btn-success"' .
                        ' type="button"' .
                        ' onclick="set_submenu(\'' . $data->id . '\')">' .
                        ' Aktif' .
                        '</button>' .
                        '</center>';
                } else {
                    $btn = '<center>' .
                        '<button class="btn btn-danger"' .
                        ' type="button"' .
                        ' onclick="set_submenu(\'' . $data->id . '\')">' .
                        ' Tidak' .
                        '</button>' .
                        '</center>';
                }
                return $btn;
            })
            ->addColumn('insert', function ($data) {
                if ($data && substr($data->privilege, 0, 1)) {
                    $btn = '<center>' .
                        ' <input type="checkbox" id="T' . $data->id . '" value="1" name="checkable" checked=""' .
                        ' class="basic-checkbox" onclick="set_access(\'' . $data->id . '\')"> ' .
                        '</center>';
                } else {
                    $btn = '<center>' .
                        ' <input type="checkbox" id="T' . $data->id . '" value="1" name="checkable"' .
                        ' class="basic-checkbox" onclick="set_access(\'' . $data->id . '\')"> ' .
                        '</center>';
                }
                return $btn;
            })
            ->addColumn('update', function ($data) {
                if ($data && substr($data->privilege, 2, 1)) {
                    $btn = '<center>' .
                        ' <input type="checkbox" id="E' . $data->id . '" value="1" name="checkable" checked=""' .
                        ' class="basic-checkbox" onclick="set_access(\'' . $data->id . '\')"> ' .
                        '</center>';
                } else {
                    $btn = '<center>' .
                        ' <input type="checkbox" id="E' . $data->id . '" value="1" name="checkable"' .
                        ' class="basic-checkbox" onclick="set_access(\'' . $data->id . '\')"> ' .
                        '</center>';
                }
                return $btn;
            })
            ->addColumn('delete', function ($data) {
                if ($data && substr($data->privilege, 4, 1)) {
                    $btn = '<center>' .
                        ' <input type="checkbox" id="H' . $data->id . '" value="1" name="checkable" checked=""' .
                        ' class="basic-checkbox" onclick="set_access(\'' . $data->id . '\')"> ' .
                        '</center>';
                } else {
                    $btn = '<center>' .
                        ' <input type="checkbox" id="H' . $data->id . '" value="1" name="checkable"' .
                        ' class="basic-checkbox" onclick="set_access(\'' . $data->id . '\')"> ' .
                        '</center>';
                }
                return $btn;
            })
            ->rawColumns(['set_access', 'insert', 'update', 'delete'])
            ->make(true);
    }

    public function insertGroupAccess(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            $get = $request->all();
            if ($get['stat'] == "submenu") {
                $cek = GroupsAccess::where('group_id', $get['group_id'])
                    ->where('menu_id', $get['menu_id'])
                    ->first();
                if ($cek) {
                    GroupsAccess::where('group_id', $get['group_id'])
                        ->where('menu_id', $get['menu_id'])
                        ->delete();
                } else {
                    GroupsAccess::insert(
                        [
                            'group_id' => $get['group_id'],
                            'menu_id' => $get['menu_id'],
                            'privilege' => $get['privilege'],
                        ]
                    );
                }
            } else {
                GroupsAccess::where('group_id', $get['group_id'])
                    ->where('menu_id', $get['menu_id'])
                    ->delete();
                GroupsAccess::insert(
                    [
                        'group_id' => $get['group_id'],
                        'menu_id' => $get['menu_id'],
                        'privilege' => $get['privilege'],
                    ]
                );
            }
            $this->message = "Data berhasil diproses";
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
    // Group Access End
}
