<table class="table table-bordered" border="1" style="width: 100%;border-collapse: collapse;">
    <tr>
        <td style="width: 40px;">No.</td>
        <td style="width: 150px;">Kode</td>
        <td>Nama Penyakit</td>
        <td style="width: 150px;">Jumlah Kasus</td>
    </tr>
    @php
        $no = 1;
        $total = 0;
    @endphp
    @foreach($data as $val)
    <tr>
        <td style="text-align: center;">{{$no}}</td>
        <td style="text-align: center;">{{$val->diagnosa_utama}}</td>
        <td>{{$val->diag_utama->title_icd}}</td>
        <td style="text-align: center;">{{$val->jml}}</td>
    </tr>
    @php
        $no++;
        $total+=$val->jml;
    @endphp
    @endforeach
    <tr>
        <td colspan="3" style="text-align: right;font-weight: bold;"> TOTAL </td>
        <td style="text-align: right;font-weight: bold;">{{number_format($total,0)}}</td>
    </tr>
</table>