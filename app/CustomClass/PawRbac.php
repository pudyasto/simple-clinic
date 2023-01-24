<?php

namespace App\CustomClass;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Groups;
use App\Models\Menus;

class PawRbac
{
    public function __construct()
    {
        
    }

    public function cekPrivileges($link, $group_id, $role = 'Insert')
    {
        $row = DB::table('groups_access')
            ->join('menus', 'groups_access.menu_id', '=', 'menus.id')
            ->where('groups_access.group_id', $group_id)
            ->where('menus.link', $link)
            ->first();
        if ($row) {
            $privilege = explode(",", $row->privilege);
            
            if ($role == "Insert") {
                if ($privilege[0] == "1") {
                    return true;
                } else {
                    return false;
                }
            } else if ($role == "Update") {
                if ($privilege[1] == "1") {
                    return true;
                } else {
                    return false;
                }
            } else if ($role == "Delete") {
                if ($privilege[2] == "1") {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function cekMenuGroup($link, $group_id)
    {
        $row = DB::table('groups_access')
            ->join('menus', 'groups_access.menu_id', '=', 'menus.id')
            ->where('groups_access.group_id', $group_id)
            ->where('menus.link', $link)
            ->count();
        if ($row > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function menuApp($link = null)
    {
        $user = Auth::user();
        $group = Groups::where('id', $user->group_id)->first();

        if ($user->username == 'administrator' || $group->name  == 'administrator') {
            $menu_sidebar = Menus::where('is_active', '1')
                ->whereNull('main_id')
                ->orderBy('menu_order','asc')->get();
        } else {
            $str = "SELECT * FROM (
                SELECT 
                    menus.id,
                    menus.menu_header,
                    menus.menu_order,
                    menus.menu_name,
                    menus.link,
                    menus.icon,
                    menus.description,
                    menus.is_active,
                    menus.main_id
                FROM
                    menus
                    JOIN
                    groups_access ON menus.id = groups_access.menu_id
                WHERE
                    (menus.main_id IS NULL)
                        AND (groups_access.group_id = '$user->group_id')
                        AND menus.is_active = '1'
                UNION ALL        
                SELECT 
                    menus.id,
                    menus.menu_header,
                    menus.menu_order,
                    menus.menu_name,
                    menus.link,
                    menus.icon,
                    menus.description,
                    menus.is_active,
                    menus.main_id
                FROM
                    menus
                INNER JOIN
                    menus as sub_menu ON sub_menu.main_id = menus.id
                    JOIN
                    groups_access ON sub_menu.id = groups_access.menu_id
                WHERE
                    (menus.main_id IS NULL)
                        AND (groups_access.group_id = '$user->group_id')
                        AND menus.is_active = '1'
                GROUP BY  
                    menus.id,
                    menus.menu_header,
                    menus.menu_order,
                    menus.menu_name,
                    menus.link,
                    menus.icon,
                    menus.description,
                    menus.is_active,
                    menus.main_id       
                ) menu
                    ORDER BY menu.menu_order ASC";
            $menu_sidebar = DB::select(DB::raw($str));
        }

        $header = array();
        $output['menus'] = array();
        foreach ($menu_sidebar as $res) {
            $row = array();
            $row['id'] = $res->id;
            $row['menu_name'] = $res->menu_name;
            $row['menu_header'] = $res->menu_header;
            $row['icon'] = $res->icon;
            $row['link'] = $res->link;
            $row['description'] = $res->description;
            $row['active'] = $this->active_menu($link, $res->id);
            $row['sub'] = $this->submenu_app($link, $res->id, $user->group_id, $user->username, isset($group->name) ? $group->name : '');
            $output['menus'][] = $row;

            if (count($row['sub']['submenu']) > 0 && $row['link'] == "#") {
                $header[$row['menu_header']] = $row['menu_header'];
            } elseif ($row['link'] !== "#") {
                $header[$row['menu_header']] = $row['menu_header'];
            }
        }
        return [
            'header' => $header,
            'output' => $output,
        ];
    }
    private function active_menu($link, $id)
    {
        $row = Menus::where('link', $link)
            ->orderBy('menu_order','asc')->get();
        foreach ($row as $val) {
            if ($val->main_id == $id) {
                return ' menu-item-open menu-item-here ';
            }else{
                return '';
            }
        }
    }

    private function submenu_app($link, $id, $group_id, $username = 'administrator', $group_name =  'administrator')
    {
        if ($username  == "administrator" || $group_name == "administrator") {

            $sub_menu_sidebar = Menus::where('is_active', '1')
                ->where('main_id', $id)
                ->orderBy('menu_order','asc')->get();
        } else {
            $str = "SELECT 
                        menus.id, 
                        menus.menu_order, 
                        menus.menu_name, 
                        menus.link, 
                        menus.icon,
                        menus.description,                        
                        menus.is_active
                    FROM 
                        menus
                    JOIN groups_access 
                        ON menus.id = groups_access.menu_id 
                    WHERE (menus.main_id='{$id}')
                        AND (groups_access.group_id = '{$group_id}')
                        AND menus.is_active = '1'
                    ORDER BY menus.menu_order ASC";
            $sub_menu_sidebar = DB::select(DB::raw($str));
        }
        $output['submenu'] = [];

        foreach ($sub_menu_sidebar as $row) {
            if ($link == $row->link) {
                $mnsub_active = ' menu-item-active ';
            } else {
                $mnsub_active = '';
            }

            if ($this->groupApp($row->id, $group_id, $username, $group_name)) {
                $mnsub = array();
                $mnsub['id'] = $row->id;
                $mnsub['menu_name'] = $row->menu_name;
                $mnsub['link'] = $row->link;
                $mnsub['icon'] = $row->icon;
                $mnsub['description'] = $row->description;
                $mnsub['sub_active'] = $mnsub_active;
                $output['submenu'][] = $mnsub;
            }
        }
        return $output;
    }

    private function groupApp($id, $group_id, $username = 'administrator', $group_name =  'administrator')
    {
        if ($username == "administrator" || $group_name == "administrator") {
            return true;
        } else {
            $str = " SELECT ga.group_id 
                    FROM groups_access AS ga 
                    WHERE (ga.group_id = '" . $group_id . "') 
                    AND (ga.menu_id = '" . $id . "') ";
            $num_row = DB::select(DB::raw($str));
            if ($num_row) {
                return true;
            } else {
                return false;
            }
        }
    }
}
