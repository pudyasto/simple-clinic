<?php

namespace App\CustomClass;

use Exception;
use Illuminate\Support\Facades\DB;

class CodeGenerator
{
    public function __construct()
    {
    }

    public static function generateCodeItem(){
        $firstCode = 'BRG';
        $kode = DB::table('barang')->select([
            DB::raw("MAX(SUBSTRING(kode,4,5)) AS kode"),
        ])
            ->whereRaw("SUBSTRING(kode,1,3) = '{$firstCode}'")
            ->first();
        if (!$kode) {
            $code = 1;
        } else {
            $code = $kode->kode + 1;
        }

        return $firstCode . str_pad($code, 5, "0", STR_PAD_LEFT);
    }

    public static function generateCodeKasir()
    {
        $firstCode = 'INV' . date('ym');
        $kode = DB::table('kasir')->select([
            DB::raw("MAX(SUBSTRING(kode,8,4)) AS kode"),
        ])
            ->whereRaw("SUBSTRING(kode,1,7) = '{$firstCode}'")
            ->first();
        if (!$kode) {
            $code = 1;
        } else {
            $code = $kode->kode + 1;
        }

        return $firstCode . str_pad($code, 4, "0", STR_PAD_LEFT);
    }

    public static function generateCodeRegistrasi()
    {
        $firstCode = date('Ym');
        $kode = DB::table('registrasi')->select([
            DB::raw("MAX(SUBSTRING(kode,7,4)) AS kode"),
        ])
            ->whereRaw("SUBSTRING(kode,1,6) = '{$firstCode}'")
            ->first();
        if (!$kode) {
            $code = 1;
        } else {
            $code = $kode->kode + 1;
        }

        return $firstCode . str_pad($code, 4, "0", STR_PAD_LEFT);
    }

    public static function generateCodeBooking(){
        $firstCode = date('ym');
        $kode = DB::table('registrasi')->select([
            DB::raw("MAX(SUBSTRING(kode_booking,5,4)) AS kode"),
        ])
            ->whereRaw("SUBSTRING(kode_booking,1,4) = '{$firstCode}'")
            ->first();
        if (!$kode) {
            $code = 1;
        } else {
            $code = $kode->kode + 1;
        }

        return $firstCode . str_pad($code, 4, "0", STR_PAD_LEFT) . str_pad(rand(1,99),2,'0',STR_PAD_LEFT);
    }

    public static function generateKodeTindakan()
    {
        $kode = DB::table('tindakan')->select([
            DB::raw("MAX(kode) AS kode"),
        ])
            ->first();
        if (!$kode) {
            $code = 1;
        } else {
            $code = $kode->kode + 1;
        }

        return str_pad($code, 4, "0", STR_PAD_LEFT);
    }

    public static function generateKodePasien($nama)
    {
        // Karakter awal berupa huruf
        $firstCode = substr($nama, 0, 1);
        $kode = DB::table('pasien')->select([
            DB::raw("MAX(SUBSTRING(no_rm,2,5)) AS kode"),
        ])
            ->whereRaw("SUBSTRING(no_rm,1,1) = '{$firstCode}'")
            ->first();
        if (!$kode) {
            $code = 1;
        } else {
            $code = $kode->kode + 1;
        }

        return $firstCode . str_pad($code, 5, "0", STR_PAD_LEFT);
    }

    public static function generateKodePegawai()
    {
        $firstCode = '1';
        $kode = DB::table('pegawai')->select([
            DB::raw("MAX(SUBSTRING(kode,2,5)) AS kode"),
        ])
            ->whereRaw("SUBSTRING(kode,1,1) = '{$firstCode}'")
            ->first();
        if (!$kode) {
            $code = 1;
        } else {
            $code = $kode->kode + 1;
        }

        return $firstCode . str_pad($code, 4, "0", STR_PAD_LEFT);
    }

    public static function generateCodeAsuransi()
    {
        $kode = DB::table('asuransi')->select([
            DB::raw("MAX(kode) AS kode"),
        ])->first();
        if (!$kode) {
            $code = 1;
        } else {
            $code = $kode->kode + 1;
        }

        return str_pad($code, 3, "0", STR_PAD_LEFT);
    }

    public static function generateCodeCabang()
    {
        $kode = DB::table('cabang')->select([
            DB::raw("MAX(kode) AS kode"),
        ])->first();
        if (!$kode) {
            $code = 1;
        } else {
            $code = $kode->kode + 1;
        }

        return str_pad($code, 4, "0", STR_PAD_LEFT);
    }
}
