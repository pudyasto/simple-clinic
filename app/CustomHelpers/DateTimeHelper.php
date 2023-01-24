<?php

function datetime_id($datetime)
{
    // formate date : YYYY-MM-DD HH:II:SS

    $dt = explode("-", $datetime);
    $yyyy = $dt[0];
    $mm = $dt[1];
    $dd = substr($dt[2],0,2);
    $time = substr($dt[2],2,20);

    $bulan = array(
        '',
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );

    if ($mm == 0 || is_numeric($mm) == false) {
        return 'Bulan Tidak Valid ';
    } elseif ($mm <= 12) {
        return $dd . " " . $bulan[(int) $mm] . " " . $yyyy . " " . $time;
    } else {
        return "Format Tanggal Tidak Valid";
    }
}

function datetime_short_id($datetime)
{
    // formate date : YYYY-MM-DD HH:II:SS
    $dt = explode("-", $datetime);
    $yyyy = $dt[0];
    $mm = $dt[1];
    $dd = substr($dt[2],0,2);
    $time = substr($dt[2],2,20);

    $bulan = array(
        '',
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agt',
        'Sep',
        'Okt',
        'Nov',
        'Des',
    );

    if ($mm == 0 || is_numeric($mm) == false) {
        return 'Bulan Tidak Valid ';
    } elseif ($mm <= 12) {
        return $dd . " " . $bulan[(int) $mm] . " " . $yyyy . " " . $time;
    } else {
        return "Format Tanggal Tidak Valid";
    }
}

function month_id($datetime)
{
    // formate date : YYYY-MM-DD HH:II:SS
    $dt = explode("-", $datetime);
    $yyyy = $dt[0];
    $mm = $dt[1];

    $bulan = array(
        '',
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );

    if ($mm == 0 || is_numeric($mm) == false) {
        return 'Bulan Tidak Valid ';
    } elseif ($mm <= 12) {
        return  $bulan[(int) $mm] . " " . $yyyy;
    } else {
        return "Format Tanggal Tidak Valid";
    }
}

function month_short_id($datetime)
{
    // formate date : YYYY-MM-DD HH:II:SS
    $dt = explode("-", $datetime);
    $yyyy = $dt[0];
    $mm = $dt[1];

    $bulan = array(
        '',
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agt',
        'Sep',
        'Okt',
        'Nov',
        'Des',
    );

    if ($mm == 0 || is_numeric($mm) == false) {
        return 'Bulan Tidak Valid ';
    } elseif ($mm <= 12) {
        return  $bulan[(int) $mm] . " " . $yyyy;
    } else {
        return "Format Tanggal Tidak Valid";
    }
}

function month_name_id($int)
{
    $bulan = array(
        '',
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agt',
        'Sep',
        'Okt',
        'Nov',
        'Des',
    );

    if ($int == 0 || is_numeric($int) == false) {
        return '-';
    } elseif ($int <= 12) {
        return  $bulan[(int) $int];
    } else {
        return "Bulan Tidak Valid";
    }
}

function dateconvert($date)
{
    if (!empty($date)) {
        $date_id = explode('-', $date);
        return $date_id[2] . '-' . $date_id[1] . '-' . $date_id[0];
    } else {
        return false;
    }
}

function dateToMonth($date)
{
    if (!empty($date)) {
        $date_id = explode('-', $date);
        return $date_id[2] . '-' . $date_id[1];
    } else {
        return false;
    }
}

function monthconvert($date)
{
    if (!empty($date)) {
        $date_id = explode('-', $date);
        return $date_id[1] . '-' . $date_id[0];
    } else {
        return false;
    }
}
function selisihmenit($datetimestart, $datetimeend)
{
    if (!empty($datetimestart) || !empty($datetimestart)) {
        $awal  = strtotime($datetimestart); //waktu awal

        $akhir = strtotime($datetimeend); //waktu akhir

        $diff  = $akhir - $awal;

        $jam   = floor($diff / (60 * 60));

        $menit = $diff - $jam * (60 * 60);

        return ($jam * 60) + floor($menit / 60);
    } else {
        return 0;
    }
}

function selisihwaktu($datetimestart, $datetimeend)
{
    if (!empty($datetimestart) || !empty($datetimestart)) {
        $awal  = strtotime($datetimestart); //waktu awal

        $akhir = strtotime($datetimeend); //waktu akhir

        $diff  = $akhir - $awal;
        $jam   = floor($diff / (60 * 60));

        $menit = $diff - $jam * (60 * 60);

        return $jam .  ' Jam, ' . floor($menit / 60) . ' Menit';
    } else {
        return 0;
    }
}

function selisihhari($datestart, $dateend)
{
    if (!empty($datestart) || !empty($dateend)) {
        $tgl1 = new DateTime($datestart);
        $tgl2 = new DateTime($dateend);
        $d = $tgl2->diff($tgl1)->days + 1;
        return $d;
    } else {
        return 0;
    }
}

function dateadd($currdate, $days = 1)
{
    if (!empty($currdate)) {
        //to a given date.
        $date = new DateTime($currdate);

        $interval = new DateInterval("P" . abs($days) . "D");

        if ($days > 0) {
            $date->add($interval);
            return $date->format("Y-m-d");
        } else {
            $interval->invert = abs($days);

            $date->add($interval);
            return $date->format("Y-m-d");
        }

        //Print out the result.
    } else {
        return 0;
    }
}

function yearadd($currdate, $year = 1)
{
    if (!empty($currdate)) {
        $res = date('Y-m-d', strtotime($year . ' years', strtotime($currdate)));
        return $res;
    } else {
        return 0;
    }
}



function calcPeriode($start_periode, $amount = 12, $period_type = 'M')
{
    $start_periode = monthconvert($start_periode) . '-01';

    $close_periode = new DateTime($start_periode);
    $interval = new DateInterval("P" . ($amount - 1) . $period_type);
    //Add the DateInterval object to our DateTime object.
    $close_periode->add($interval);
    $active_periode = $start_periode;

    return [
        'start_periode' => $start_periode,
        'close_periode' => $close_periode->format("Y-m-t"),
        'active_periode' => $active_periode,
        'start_periode_id' => datetime_id($start_periode),
        'close_periode_id' => datetime_id($close_periode->format("Y-m-t")),
        'active_periode_id' => datetime_id($active_periode),
    ];
}

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

// Function to get all the dates in given range 
function getDatesFromRange($start, $end, $format = 'Y-m-d')
{
    // Declare an empty array 
    $array = array();
    $data = array();

    // Variable that store the date interval 
    // of period 1 day 
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    // Use loop to store date into array 
    foreach ($period as $date) {
        $array[] = $date->format($format);
    }

    // Return the array elements 
    $res = array_unique($array);
    foreach ($res as $val) {
        $data[] = $val;
    }
    return $data;
} 

function hitung_umur($param, $param2 = null, $format = 'Ymd')
{
    $date1 = new DateTime(date('Y-m-d', strtotime($param)));
    if (empty($param2)) {
        $date2 = new DateTime(date('Y-m-d'));
    } else {
        $date2 = new DateTime(date($param2));
    }

    $y = '';
    $m = '';
    $d = '';
    $interval = $date1->diff($date2);
    if ($interval->y > '0') {
        $y = $interval->y . " Th ";
    }
    if ($interval->m > '0') {
        $m = $interval->m . " Bln ";
    }
    if ($interval->d > '0') {
        $d = $interval->d . " Hr ";
    }
    if ($format == 'num') {
        return $interval->y . "," . $interval->m . "," . $interval->d;
    } elseif ($format == 'Ymd') {
        return $y . $m . $d;
    } elseif ($format == 'Ym') {
        return $y . $m;
    } elseif ($format == 'Y') {
        return $y;
    } else {
        return $y . $m . $d;
    }
}

/* 
 * Created by Pudyasto Adi Wibowo
 * Email : pawdev.id@gmail.com
 * pudyasto.wibowo@gmail.com
 */
