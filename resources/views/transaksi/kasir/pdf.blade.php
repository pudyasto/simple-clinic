<table style="width: 100%;">
    <tr>
        <td style="width: 130px;">
            No. RM
        </td>
        <td>
            : {{$data->pasien->no_rm}}
        </td>
        <td style="width: 130px;">
            Invocie
        </td>
        <td style="width: 200px;">
            : {{$data->kode}}
        </td>
    </tr>
    <tr>
        <td>
            Nama Pasien
        </td>
        <td>
            : {{$data->pasien->nama_pasien}}
        </td>
        <td>
            Tgl Transaksi
        </td>
        <td>
            : {{datetime_id($data->tgl_bayar)}}
        </td>
    </tr>
</table>
<hr>
<table border="1" style="width: 100%;border-collapse:collapse;">
    <tr>
        <td style="width: 30px;text-align: center;">
            No.
        </td>
        <td style="text-align: center;">
            Daftar Pelayanan
        </td>
        <td style="width: 200px;text-align: center;">
            Tarif
        </td>
    </tr>
    @php
        $no = 1;
    @endphp
    @foreach($data->detail as $val)
        <tr>
            <td style="text-align: center;">
                {{$no}}
            </td>
            <td>
                {{$val->nama}}
            </td>
            <td style="text-align: right;">
                {{number_format($val->subtotal,2)}}
            </td>
        </tr>
    @php
        $no++;
    @endphp
    @endforeach
    <tr>
        <td colspan="2" style="text-align: right;font-weight: bold;">
            Total
        </td>
        <td style="text-align: right;font-weight: bold;">
            {{number_format($data->subtotal,2)}}
        </td>
    </tr>
</table>
<br>
Terbilang :
<br>
<strong>{{ucwords(terbilang($data->subtotal))}}</strong>
<table border="0" style="width: 100%;border-collapse:collapse;">
    <tr>
        <td></td>
        <td style="width: 25%;text-align: center;">
            Semarang, {{datetime_id(date('Y-m-d'))}}
            <br>
            <br>
            <br>
            <br>
            <br>
            {{$data->pegawai->nama}}
        </td>
    </tr>
</table>