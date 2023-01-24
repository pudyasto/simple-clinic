<?php

use App\Models\Locations;
use Illuminate\Support\Facades\Auth;

function errorValidasi($array)
{
    $arr = json_decode($array, true);
    $pesan = '';
    foreach ($arr as $key => $val) {
        foreach ($val as $sub_val) {
            $pesan .= $sub_val . '<br>';
        }
    }
    return $pesan;
}

function errorMessage($msg){
    $param = (str_replace("\n", "", str_replace('"', "|", $msg)));
    if (strpos($param, 'foreign key constraint fails') || strpos($param, 'violates foreign key constraint')) {
        return "Data tidak dapat dihapus karena terelasi dengan data lain!"; //  "<br> Msg : " . substr($param, 0, strpos($param, '(') - 1)
    } elseif (strpos(strtolower($param), 'value violates unique constraint')) {
        return "Data tidak boleh sama <br> Msg : " . $param;
    } elseif (strpos(strtolower($param), 'plicate entry')) {
        return "Data tidak boleh sama <br> Msg : " . $param;
    } else {
        return $param;
    }
}

function getLocationsSub(){
    $location_id = Auth::user()->location_id;

    $cabang = Locations::where('id', $location_id)->whereNotNull('parent')->first();
    if($cabang){
        // Jika cabang maka akan mengambil data pusat dan cabang lainnya
        $location_id = $cabang->parent;
    }
    $res[] = $location_id;
    $loc = Locations::where('locations.id', $location_id)
            ->join('locations as sub', 'sub.parent','=','locations.id')
            ->select([
                'sub.id'
            ])
            ->get();
    if($loc){
        // Jika ini adalah lokasi induk :
        foreach($loc as $val){
            array_push($res, $val->id);
        }
    }

    return $res;
}

function getReturType($piutang = null){
    $arr = [
        'Barang',
        'Uang',
    ];

    if($piutang!=='Lunas'){
        array_push($arr, 'Piutang');
    }

    return $arr;
}