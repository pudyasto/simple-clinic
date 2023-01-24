<?php

namespace App\CustomClass;


use Illuminate\Support\Facades\Http;

class Bpjs
{
    protected $kodePPK = '';
    protected $consId = '';
    protected $secretKey = '';
    protected $timeStamp = '';
    protected $encodedSignature = '';
    protected $user_key = '';
    protected $urlWsBpjs = '';
    protected $urlWsJkn = '';

    public function __construct()
    {
        date_default_timezone_set('UTC');

        $this->kodePPK = '1101R009';
        $this->consId = '23328';
        $this->secretKey = '0fCFB7020D';
        $this->user_key = '6cfc1cbcb0448007ac3e7a108596112a';

        $this->timeStamp = strval(time() - strtotime('1970-01-01 00:00:00'));

        $signature = hash_hmac('sha256', $this->consId . "&" . $this->timeStamp, $this->secretKey, true);
        $this->encodedSignature = base64_encode($signature);

        $this->urlWsJkn = "https://apijkn.bpjs-kesehatan.go.id/antreanrs/";
        date_default_timezone_set('Asia/Jakarta');
    }

    /*
     * Fungsi : Get data Dokter
     * Method : GET
     * Format : Json
     * Content-Type: application/json
     */
    public function getDokter()
    {
        $response = Http::withHeaders([
            'X-cons-id' => $this->consId,
            'X-timestamp' => $this->timeStamp,
            'X-signature' => $this->encodedSignature,
            'user_key' => $this->user_key,
        ])->get($this->urlWsJkn . "ref/dokter")->body();
        return $response;
    }

    /*
     * Fungsi : Get data Jadwal Dokter
     * Method : GET
     * Format : Json
     * Content-Type: application/json
     */
    public function getJadwalDokter($kode_poli, $tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        $response = Http::withHeaders([
            'X-cons-id' => $this->consId,
            'X-timestamp' => $this->timeStamp,
            'X-signature' => $this->encodedSignature,
            'user_key' => $this->user_key,
        ])->get($this->urlWsJkn . "jadwaldokter/kodepoli/{$kode_poli}/tanggal/{$tanggal}")->body();
        return $response;
    }

    /*
     * Fungsi : Update data Jadwal Dokter
     * Method : GET
     * Format : Json
     * Content-Type: application/json
     */
    public function updateJadwalDokter($array)
    {
        $response = Http::withHeaders([
            'X-cons-id' => $this->consId,
            'X-timestamp' => $this->timeStamp,
            'X-signature' => $this->encodedSignature,
            'user_key' => $this->user_key,
        ])->post($this->urlWsJkn . "jadwaldokter/updatejadwaldokter", $array)->body();
        return $response;
    }

    /*
     * Fungsi : Get data poli
     * Method : GET
     * Format : Json
     * Content-Type: application/json
     */
    public function getDataPoli()
    {
        $response = Http::withHeaders([
            'X-cons-id' => $this->consId,
            'X-timestamp' => $this->timeStamp,
            'X-signature' => $this->encodedSignature,
            'user_key' => $this->user_key,
        ])->get($this->urlWsJkn . "ref/poli")->body();
        return $response;
    }

    /*
     * Fungsi : Tambah data antrean
     * Method : POST
     * Format : Json
     * Content-Type: application/json
     */
    public function tambahAntrean($array)
    {
        // {
        //     "kodebooking": "{kodebooking yang dibuat unik}",
        //     "jenispasien": "{JKN / NON JKN}",
        //     "nomorkartu": "{noka pasien BPJS,diisi kosong jika NON JKN}",
        //     "nik": "{nik pasien}",
        //     "nohp": "{no hp pasien}",
        //     "kodepoli": "{memakai kode poli BPJS}",
        //     "namapoli": "{nama poli}",
        //     "pasienbaru": {1(Ya),0(Tidak)},
        //     "norm": "{no rekam medis pasien}",
        //     "tanggalperiksa": "{tanggal periksa}",
        //     "kodedokter": {kode dokter BPJS},
        //     "namadokter": "{nama dokter}",
        //     "jampraktek": "{jam praktek dokter}",
        //     "jeniskunjungan": {1 (Rujukan FKTP), 2 (Rujukan Internal), 3 (Kontrol), 4 (Rujukan Antar RS)},
        //     "nomorreferensi": "{norujukan/kontrol pasien JKN,diisi kosong jika NON JKN}",
        //     "nomorantrean": "{nomor antrean pasien}",
        //     "angkaantrean": {angka antrean},
        //     "estimasidilayani": {waktu estimasi dilayani dalam miliseconds},
        //     "sisakuotajkn": {sisa kuota JKN},
        //     "kuotajkn": {kuota JKN},
        //     "sisakuotanonjkn": {sisa kuota non JKN},
        //     "kuotanonjkn": {kuota non JKN},
        //     "keterangan": "{informasi untuk pasien}"
        // }          
        $response = Http::withHeaders([
            'X-cons-id' => $this->consId,
            'X-timestamp' => $this->timeStamp,
            'X-signature' => $this->encodedSignature,
            'user_key' => $this->user_key,
        ])->post($this->urlWsJkn . "antrean/add", $array)->body();
        return $response;
    }

    /*
     * Fungsi : Update waktu antrean
     * Method : POST
     * Format : Json
     * Content-Type: application/json
     */
    public function updateWaktuAntrean($array)
    {
        // {
        //     "kodebooking": "{kodebooking yang didapat dari servis tambah antrean}",
        //     "taskid": {
        //                  1 (mulai waktu tunggu admisi), 
        //                  2 (akhir waktu tunggu admisi/mulai waktu layan admisi), 
        //                  3 (akhir waktu layan admisi/mulai waktu tunggu poli), 
        //                  4 (akhir waktu tunggu poli/mulai waktu layan poli),  
        //                  5 (akhir waktu layan poli/mulai waktu tunggu farmasi), 
        //                  6 (akhir waktu tunggu farmasi/mulai waktu layan farmasi membuat obat), 
        //                  7 (akhir waktu obat selesai dibuat),
        //                  99 (tidak hadir/batal)
        //              },
        //     "waktu": {waktu dalam timestamp milisecond}
        // }               
        $response = Http::withHeaders([
            'X-cons-id' => $this->consId,
            'X-timestamp' => $this->timeStamp,
            'X-signature' => $this->encodedSignature,
            'user_key' => $this->user_key,
        ])->post($this->urlWsJkn . "antrean/updatewaktu", $array)->body();
        return $response;
    }

    /*
     * Fungsi : Batal antrean
     * Method : POST
     * Format : Json
     * Content-Type: application/json
     */
    public function batalAntrean($array)
    {
        // {
        //     "kodebooking": "{kodebooking yang didapat dari servis tambah antrean}",
        //     "keterangan": "{alasan pembatalan}"
        // }               
        $response = Http::withHeaders([
            'X-cons-id' => $this->consId,
            'X-timestamp' => $this->timeStamp,
            'X-signature' => $this->encodedSignature,
            'user_key' => $this->user_key,
        ])->post($this->urlWsJkn . "antrean/batal", $array)->body();
        return $response;
    }

    /*
     * Fungsi : List Waktu Task Id
     * Method : POST
     * Format : Json
     * Content-Type: application/json
     */
    public function listWaktuTask($array)
    {
        // {
        //     "kodebooking": "{kodebooking yang didapat dari servis tambah antrean}",
        // }               
        $response = Http::withHeaders([
            'X-cons-id' => $this->consId,
            'X-timestamp' => $this->timeStamp,
            'X-signature' => $this->encodedSignature,
            'user_key' => $this->user_key,
        ])->post($this->urlWsJkn . "antrean/getlisttask", $array)->body();
        return $response;
    }

    /*
     * Fungsi : Dashboard per Tanggal
     * Method : POST
     * Format : Json
     * Content-Type: application/json
     */
    public function getDashboardPerTanggal($tanggal = null, $waktu = 'server')
    {
        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        $response = Http::withHeaders([
            'X-cons-id' => $this->consId,
            'X-timestamp' => $this->timeStamp,
            'X-signature' => $this->encodedSignature,
            'user_key' => $this->user_key,
        ])->get($this->urlWsJkn . "dashboard/waktutunggu/tanggal/{$tanggal}/waktu/{$waktu}")->body();
        return $response;
    }

    /*
     * Fungsi : Dashboard per Bulan
     * Method : POST
     * Format : Json
     * Content-Type: application/json
     */
    public function getDashboardPerBulan($bulan = null, $tahun = null, $waktu = 'server')
    {
        if (!$bulan) {
            $bulan = date('m');
        }

        if (!$tahun) {
            $tahun = date('Y');
        }

        $response = Http::withHeaders([
            'X-cons-id' => $this->consId,
            'X-timestamp' => $this->timeStamp,
            'X-signature' => $this->encodedSignature,
            'user_key' => $this->user_key,
        ])->get($this->urlWsJkn . "dashboard/waktutunggu/bulan/{$bulan}/tahun/{$tahun}/waktu/{$waktu}")->body();
        return $response;
    }

    public function stringDecrypt($string)
    {
        $key = $this->consId . $this->secretKey . $this->timeStamp;
        $encrypt_method = 'AES-256-CBC';

        // hash
        $key_hash = hex2bin(hash('sha256', $key));

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        return $output;
    }

    // function lzstring decompress 
    // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
    public function decompress($string)
    {
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }

    public static function errorBpjs($string)
    {
        if ($string == 'No Content') {
            return "Jadwal dokter belum tersedia, silahkan hubungi BPJS";
        } else {
            return $string;
        }
    }
}
