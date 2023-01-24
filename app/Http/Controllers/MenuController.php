<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Menus;
use Exception;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
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
        return view('rbac.menu.index', []);
    }

    public function formAdd(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        return view('rbac.menu.form', [
            'url' => url('/menu/insertData'),
            'is_active' => $this->data['is_active'],
        ]);
    }

    public function formEdit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Menus::where('id', $request->id)->first();
        return view('rbac.menu.form', [
            'url' => url('/menu/updateData'),
            'is_active' => $this->data['is_active'],
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
                'menu_name'     => 'required',
                'description'   => 'required',
                'link'          => 'required',
                'is_active'     => 'required',
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

            $this->response = Menus::create([
                'menu_order'    => $request->menu_order,
                'menu_header'   => ($request->menu_header) ? $request->menu_header : '',
                'menu_name'     => $request->menu_name,
                'description'   => $request->description,
                'link'          => $request->link,
                'icon'          => $request->icon,
                'main_id'       => $request->main_id,
                'is_active'     => $request->is_active,
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
                'menu_name'     => 'required',
                'description'   => 'required',
                'link'          => 'required',
                'is_active'     => 'required',
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

            $this->response = Menus::where('id', '=', $request->id)->update([
                'menu_order'    => $request->menu_order,
                'menu_header'   => ($request->menu_header) ? $request->menu_header : '',
                'menu_name'     => $request->menu_name,
                'description'   => $request->description,
                'link'          => $request->link,
                'icon'          => $request->icon,
                'main_id'       => $request->main_id,
                'is_active'     => $request->is_active,
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

            $arr_id = json_decode($request->id);
            $this->response = Menus::where('id', '=', $request->id)->delete();
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

        $table = "SELECT icon, menu_name, submenu, description, id, menu_header,is_active FROM (SELECT
                        submenu.id,
                        CASE WHEN menus.menu_name IS NULL 
                            THEN submenu.menu_name 
                            ELSE menus.menu_name 
                        END AS menu_name,
                        CASE WHEN menus.menu_name IS NULL 
                            THEN '' 
                            ELSE submenu.menu_name 
                        END AS submenu,
                        submenu.description,
                        submenu.link,
                        submenu.icon,
                        submenu.menu_header,
                        CASE WHEN submenu.is_active = '1' THEN 'Aktif' 
                            ELSE 'Tidak'
                        END AS is_active
                    FROM
                            menus
                    RIGHT JOIN menus AS submenu 
                            ON submenu.main_id = menus.id
                    WHERE
                            menus.main_id IS NULL
                    ORDER BY CASE WHEN menus.menu_name IS NULL 
                            THEN submenu.menu_name 
                            ELSE menus.menu_name 
                        END
                        , CASE WHEN menus.menu_name IS NULL 
                            THEN '0' 
                            ELSE submenu.menu_name 
                        END
                    ) AS a ";

        $data  = DB::select(DB::raw($table));
        return DataTables::of($data)
            ->addColumn('icon', function ($data) {
                if (!$data->submenu) {
                    $btn = '<i data-feather="' . $data->icon . '"></i>';
                } else {
                    $btn = '';
                }
                return $btn;
            })
            ->addColumn('btn', function ($data) {
                $menu = (!$data->submenu) ? $data->menu_name : $data->submenu;
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-info btn-sm"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data : ' . $menu . '"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="menu/formEdit/"' .
                    ' data-bs-target="#form-modal">' .
                    'Edit' .
                    '</button>' .
                    '<button class="btn btn-danger btn-sm "' .
                    ' onclick="deleteData(\'' . $data->id . '\');">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['icon', 'btn',])
            ->make(true);
    }

    public function getMainMenu(Request $request)
    {
        $menus = Menus::whereNull('main_id')->get();
        return response()->json($menus);
    }
}
