<?php

namespace App\Http\Controllers;

use App\Models\PoliTindakan;
use App\Models\PoliUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class RptTrendPenyakitController extends Controller
{
    //
    protected $message = 'Data berhasil di proses';
    protected $code = 200;
    protected $response = array();
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        return view('laporan.trendpenyakit.index', []);
    }

    public function previewData(Request $request){
        $data = $this->getData($request);
        return view('laporan.trendpenyakit.pdf', [
            'data' => $data,
        ]);
    }

    public function printData(Request $request){
        $data = $this->getData($request);
        if (!$data) {
            return redirect('');
        }
        $title = 'Laporan Trend Penyakit';
        $mpdf = new Mpdf([
            'tempDir' =>  storage_path('framework'),
            'default_font' => 'Arial',
        ]);

        $header = headerPdf($title, 'My Clinic', 'Srikaton Selatan No. 31', 'Semarang');
        $mpdf->setTitle($title);
        $mpdf->SetHTMLHeader($header);

        $mpdf->SetWatermarkImage(public_path('/images/logo-watermark.png'), 0.1,);
        $mpdf->showWatermarkImage = true;

        $mpdf->SetHTMLFooter('
        <table width="100%">
            <tr>
                <td width="70%"><i><small>Dicetak Tanggal : {DATE d-m-Y H:i:s} , Oleh : ' . Auth::user()->name . '</small></i></td>
                <td width="30%" style="text-align: right;"><i><small>Halaman {PAGENO} / Dari {nbpg}</small></i></td>
            </tr>
        </table>');

        $margin_left = 5;
        $margin_right = 5;
        $margin_top = 25;
        $margin_bottom = 5;
        $paper_type = 'Legal';

        $mpdf->AddPage('P', '', '', '', '', $margin_left, $margin_right, $margin_top, $margin_bottom, 5, 5, '', '', '', '', '', '', '', '', '', $paper_type);
        $mpdf->WriteHTML(view('laporan.trendpenyakit.pdf', [
            'data' => $data,
        ]));

        $mpdf->Output();
    }

    private function getData($request){
        $registrasi = PoliUmum::with(['diag_utama'])
            ->join('registrasi','registrasi.id','=','poli_umum.registrasi_id')
            ->whereRaw(" date_format(registrasi.tgl_daftar, '%Y-%m') = '". monthconvert($request->tgl_mulai) ."' ")
            ->select([
                'poli_umum.diagnosa_utama',
                DB::raw('COUNT(poli_umum.diagnosa_utama) AS jml')
            ])
            ->groupBy([
                'poli_umum.diagnosa_utama',
            ])
            ->get();
        return $registrasi;
    }
}
