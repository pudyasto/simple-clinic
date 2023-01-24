<table class="table table-bordered" border="1" style="width: 100%;border-collapse: collapse;">
    <tr>
        <td style="width: 40px;">No.</td>
        <td style="width: 150px;">Tanggal</td>
        <td style="width: 120px;">No. Registrasi</td>
        <td style="width: 80px;">No. RM</td>
        <td style="width: 250px;">Nama Pasien</td>
        <td style="width: 100px;">Kelamin</td>
        <td style="width: 150px;">Usia</td>
        <td style="width: 100px;">Poli</td>
        <td style="width: 150px;">Subtotal</td>
    </tr>
    @php
        $no = 1;
        $total = 0;
    @endphp
    @foreach($data as $val)
    <tr>
        <td style="text-align: center;">{{$no}}</td>
        <td style="text-align: center;">{{ datetime_short_id($val->tgl_bayar) }}</td>
        <td style="text-align: center;">{{$val->kode}}</td>
        <td style="text-align: center;">{{$val->pasien->no_rm}}</td>
        <td>{{$val->pasien->nama_pasien}}</td>
        <td style="text-align: center;">{{$val->pasien->jenis_kelamin}}</td>
        <td style="text-align: center;">{{ hitung_umur($val->pasien->tgl_lahir,$val->tgl_kunjungan, 'Ym') }}</td>
        <td>{{$val->poli->nama}}</td>
        <td style="text-align: right;">{{number_format($val->subtotal,0)}}</td>
    </tr>
    @php
        $no++;
        $total+=$val->subtotal;
    @endphp
    @endforeach
    <tr>
        <td colspan="8" style="text-align: right;font-weight: bold;"> TOTAL </td>
        <td style="text-align: right;font-weight: bold;">{{number_format($total,0)}}</td>
    </tr>
</table>