<?php

namespace App\CustomClass;

use App\Models\Registrasi;
use Exception;
use Illuminate\Support\Facades\DB;

class Clinic
{
    public function __construct()
    {
    }

    public static function getDataRegister($id, $kode_booking)
    {
        $data = Registrasi::with(['pasien', 'pegawai', 'poli'])
            ->where("registrasi.id", $id)
            ->where("registrasi.kode_booking", $kode_booking)
            ->where("registrasi.stat_kunjungan", 'Konfirmasi')
            ->select([
                'registrasi.*',
            ]);

        return $data->first();
    }

    public static function getDataPemeriksaan($id, $kode_booking)
    {
        $data = Registrasi::with(['pasien', 'pegawai', 'poli'])
            ->where("registrasi.id", $id)
            ->where("registrasi.kode_booking", $kode_booking)
            // ->where("registrasi.stat_kunjungan", 'Pemeriksaan')
            ->select([
                'registrasi.*',
            ]);

        return $data->first();
    }
}
