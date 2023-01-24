<?php

namespace App\Http\Controllers;

use App\CustomClass\Clinic;
use App\CustomClass\CodeGenerator;
use App\Models\Kasir;
use App\Models\KasirDetail;
use App\Models\PoliResep;
use App\Models\PoliTindakan;
use App\Models\Registrasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

use Mpdf\Mpdf;

class KasirController extends Controller
{
    //
    protected $message = 'Data berhasil di proses';
    protected $res_code = 200;
    protected $response = array();

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('transaksi.kasir.index', []);
    }

    public function bayar(Request $request)
    {
        $register = Clinic::getDataPemeriksaan($request->id, $request->booking);

        if (!$register) {
            return redirect('kasir');
        }

        return view('transaksi.kasir.formBayar', [
            'register' => $register,
            'url' => url('kasir/submit'),
        ]);
    }

    public function tablePembayaran(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }

        $tindakan = PoliTindakan::whereRaw("poli_tindakan.registrasi_id = '" . $request->registrasi_id . "'")
            ->select([
                DB::raw("'Tindakan' AS jenis_pelayanan"),
                DB::raw("'poli_tindakan' AS tabel"),
                'poli_tindakan.nama',
                DB::raw('1 AS qty'),
                'poli_tindakan.tarif',
                DB::raw('poli_tindakan.tarif AS subtotal'),
            ]);

        $resep = PoliResep::join('barang', 'barang.id', '=', 'poli_resep.barang_id')
            ->whereRaw("poli_resep.registrasi_id = '" . $request->registrasi_id . "'")
            ->union($tindakan)
            ->select([
                DB::raw("'Obat' AS jenis_pelayanan"),
                DB::raw("'poli_resep' AS tabel"),
                'barang.nama',
                DB::raw('poli_resep.qty'),
                DB::raw('(poli_resep.harga_jual / poli_resep.qty) AS tarif'),
                DB::raw('poli_resep.harga_jual AS subtotal'),
            ]);

        $subqr = DB::table(DB::raw("({$resep->toSql()}) as sub"));

        return DataTables::of($subqr)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<button type="button" class="btn btn-danger btn-sm btn-hapus-tindakan">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function submitKasir(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            $validator = Validator::make($request->all(), [
                'registrasi_id' => 'required|numeric',
                'subtotal' => 'required|numeric|min:0',
                'bayar' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->res_code = 202;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->res_code,
                    ),
                    'response' => $errors,
                ], $this->res_code);
            }
            DB::beginTransaction();

            $registrasi = Registrasi::where('id', $request->registrasi_id)->first();

            $exist = Kasir::where('registrasi_id', $request->registrasi_id)->first();

            if (!$exist) {
                $kasir = Kasir::create([
                    'registrasi_id' => $request->registrasi_id,
                    'tgl_bayar' => date('Y-m-d H:i:s'),
                    'kode' => CodeGenerator::generateCodeKasir(),

                    'pasien_id' => $registrasi->pasien_id,
                    'poli_id' => $registrasi->poli_id,
                    'asuransi_id' => $registrasi->asuransi_id,
                    'nomor_asuransi' => $registrasi->nomor_asuransi,
                    'pegawai_id' => $registrasi->pegawai_id,

                    'subtotal' => $request->subtotal,
                    'diskon' => $request->diskon,
                    'bayar' => $request->bayar,
                    'kembali' => $request->kembali,

                    'user_id' => Auth::user()->id,
                ]);

                $registrasi_id = $kasir->registrasi_id;
                $kode = $kasir->kode;

                $tindakan = PoliTindakan::whereRaw("poli_tindakan.registrasi_id = '" . $request->registrasi_id . "'")
                    ->select([
                        DB::raw("'Tindakan' AS jenis_pelayanan"),
                        DB::raw("'poli_tindakan' AS tabel"),
                        'poli_tindakan.nama',
                        DB::raw('1 AS qty'),
                        'poli_tindakan.tarif',
                        DB::raw('poli_tindakan.tarif AS subtotal'),
                    ]);

                $resep = PoliResep::join('barang', 'barang.id', '=', 'poli_resep.barang_id')
                    ->whereRaw("poli_resep.registrasi_id = '" . $request->registrasi_id . "'")
                    ->union($tindakan)
                    ->select([
                        DB::raw("'Obat' AS jenis_pelayanan"),
                        DB::raw("'poli_resep' AS tabel"),
                        'barang.nama',
                        DB::raw('poli_resep.qty'),
                        DB::raw('(poli_resep.harga_jual / poli_resep.qty) AS tarif'),
                        DB::raw('poli_resep.harga_jual AS subtotal'),
                    ]);

                foreach ($resep->get() as $val) {
                    KasirDetail::create([
                        'kasir_id' => $kasir->id,
                        'jenis_pelayanan' => $val->jenis_pelayanan,
                        'nama' => $val->nama,

                        'harga' => $val->tarif,
                        'qty' => $val->qty,
                        'diskon' => 0,
                        'subtotal' => $val->subtotal,
                    ]);
                }
            } else {

                $kasir = Kasir::where('registrasi_id', $request->registrasi_id)->update([
                    'registrasi_id' => $request->registrasi_id,
                    'tgl_bayar' => date('Y-m-d H:i:s'),

                    'pasien_id' => $registrasi->pasien_id,
                    'poli_id' => $registrasi->poli_id,
                    'asuransi_id' => $registrasi->asuransi_id,
                    'nomor_asuransi' => $registrasi->nomor_asuransi,
                    'pegawai_id' => $registrasi->pegawai_id,

                    'subtotal' => $request->subtotal,
                    'diskon' => $request->diskon,
                    'bayar' => $request->bayar,
                    'kembali' => $request->kembali,

                    'user_id' => Auth::user()->id,
                ]);
                
                $registrasi_id = $exist->registrasi_id;
                $kode = $exist->kode;

                KasirDetail::where('kasir_id', $exist->id)->delete();

                $tindakan = PoliTindakan::whereRaw("poli_tindakan.registrasi_id = '" . $request->registrasi_id . "'")
                    ->select([
                        DB::raw("'Tindakan' AS jenis_pelayanan"),
                        DB::raw("'poli_tindakan' AS tabel"),
                        'poli_tindakan.nama',
                        DB::raw('1 AS qty'),
                        'poli_tindakan.tarif',
                        DB::raw('poli_tindakan.tarif AS subtotal'),
                    ]);

                $resep = PoliResep::join('barang', 'barang.id', '=', 'poli_resep.barang_id')
                    ->whereRaw("poli_resep.registrasi_id = '" . $request->registrasi_id . "'")
                    ->union($tindakan)
                    ->select([
                        DB::raw("'Obat' AS jenis_pelayanan"),
                        DB::raw("'poli_resep' AS tabel"),
                        'barang.nama',
                        DB::raw('poli_resep.qty'),
                        DB::raw('(poli_resep.harga_jual / poli_resep.qty) AS tarif'),
                        DB::raw('poli_resep.harga_jual AS subtotal'),
                    ]);

                foreach ($resep->get() as $val) {
                    KasirDetail::create([
                        'kasir_id' => $exist->id,
                        'jenis_pelayanan' => $val->jenis_pelayanan,
                        'nama' => $val->nama,

                        'harga' => $val->tarif,
                        'qty' => $val->qty,
                        'diskon' => 0,
                        'subtotal' => $val->subtotal,
                    ]);
                }
            }



            Registrasi::where('id', $request->registrasi_id)->update([
                'stat_kunjungan' => 'Selesai'
            ]);
            $this->message = "Data berhasil disimpan";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = $e->getMessage();
            $this->res_code = 202;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->res_code,
            ),
            'response' => [
                'registrasi_id' => $registrasi_id,
                'kode' => $kode
            ],
        ], $this->res_code);
    }

    public function print(Request $request)
    {
        $data = Kasir::with(['detail', 'poli', 'pasien', 'pegawai'])
            ->where('kasir.registrasi_id', $request->id)
            ->select([
                'kasir.*',
            ])
            ->first();
        if (!$data) {
            return redirect('');
        }
        $title = 'Invoice';
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
        $mpdf->WriteHTML(view('transaksi.kasir.pdf', [
            'data' => $data,
        ]));

        $mpdf->Output();
    }
}
