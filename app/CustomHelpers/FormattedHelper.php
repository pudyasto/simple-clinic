<?php

use App\Models\Registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

function terbilang($angka)
{
    $angka = (float)$angka;
    $bilangan = array(
        '',
        'satu',
        'dua',
        'tiga',
        'empat',
        'lima',
        'enam',
        'tujuh',
        'delapan',
        'sembilan',
        'sepuluh',
        'sebelas'
    );

    if ($angka < 12) {
        return $bilangan[$angka];
    } else if ($angka < 20) {
        return $bilangan[$angka - 10] . ' belas';
    } else if ($angka < 100) {
        $hasil_bagi = (int)($angka / 10);
        $hasil_mod = $angka % 10;
        return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
    } else if ($angka < 200) {
        return sprintf('seratus %s', terbilang($angka - 100));
    } else if ($angka < 1000) {
        $hasil_bagi = (int)($angka / 100);
        $hasil_mod = $angka % 100;
        return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
    } else if ($angka < 2000) {
        return trim(sprintf('seribu %s', terbilang($angka - 1000)));
    } else if ($angka < 1000000) {
        $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
        $hasil_mod = $angka % 1000;
        return sprintf('%s ribu %s', terbilang($hasil_bagi), terbilang($hasil_mod));
    } else if ($angka < 1000000000) {

        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
        $hasil_bagi = (int)($angka / 1000000);
        $hasil_mod = $angka % 1000000;
        return trim(sprintf('%s juta %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000) {
        // bilangan 'milyaran'
        $hasil_bagi = (int)($angka / 1000000000);
        $hasil_mod = fmod($angka, 1000000000);
        return trim(sprintf('%s milyar %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000000) {
        // bilangan 'triliun'                           
        $hasil_bagi = $angka / 1000000000000;
        $hasil_mod = fmod($angka, 1000000000000);
        return trim(sprintf('%s triliun %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else {
        return 'Format angka melebihi batas';
    }
}

function headerPdf($title, $company_name, $company_addr, $location_name)
{

    $header = '<table width="100%">';
    $header .= '<tr>';
    $header .= '<td style="text-align: left;">';
    $header .= '<h3>' . $company_name . '</h3>';
    $header .= '</td>';
    $header .= '<td style="text-align: right;">';
    $header .= '<h3>' . $title . '</h3>';
    $header .= '</td>';
    $header .= '</tr>';
    $header .= '<tr>';
    $header .= '<td style="text-align: left;">';
    $header .= '<small>' . $company_addr . '</small>';
    $header .= '</td>';
    $header .= '<td style="text-align: right;">';
    $header .= 'Cabang : ' . $location_name;
    $header .= '</td>';
    $header .= '</tr>';
    $header .= '</table>';
    $header .= '<hr>';

    return $header;
}

function getNumberFormat($money)
{
    $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
    $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

    $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

    $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
    $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

    return (float) str_replace(',', '.', $removedThousandSeparator);
}

function getKota($prov_id)
{
    return response()->json([
        'metadata' => array(
            'message' => 'Data berhasil di proses',
            'code' => 200,
        ),
        'response' => DB::table('kota')->where('prov_id', $prov_id)->orderBy('kota_nama')->get(),
    ], 200);
}

function getKecamatan($kota_id)
{
    return response()->json([
        'metadata' => array(
            'message' => 'Data berhasil di proses',
            'code' => 200,
        ),
        'response' => DB::table('kecamatan')->where('kota_id', $kota_id)->orderBy('kec_nama')->get(),
    ], 200);
}

function getKelurahan($kec_id)
{
    return response()->json([
        'metadata' => array(
            'message' => 'Data berhasil di proses',
            'code' => 200,
        ),
        'response' => DB::table('kelurahan')->where('kec_id', $kec_id)->orderBy('kel_nama')->get(),
    ], 200);
}

function getUrutDokter($pegawai_id, $tanggal)
{
    $dokter_urut = Registrasi::where('tgl_kunjungan', $tanggal)
                    ->where('pegawai_id', $pegawai_id)
                    ->max('dokter_urut');
    return $dokter_urut + 1;
}