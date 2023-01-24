<?php

use App\CustomClass\Clinic;
use App\Http\Controllers\AsuransiController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangJenisController;
use App\Http\Controllers\BarangKategoriController;
use App\Http\Controllers\BarangSatuanController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PegawaiJenisController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\PoliUmumController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\RptKunjunganController;
use App\Http\Controllers\RptPendapatanController;
use App\Http\Controllers\RptTrendPenyakitController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\UserController;
use App\Models\Pasien;
use App\Models\PoliPenunjang;
use App\Models\PoliUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


// Group Routes untuk modul yang memerlukan login aplikasi
Route::group([
    'middleware' => ['auth:sanctum', 'verified']
], function () {

    // Route untuk modul dashboard
    Route::group([
        'prefix' => 'home',
    ], function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
    });

    // Route untuk modul reference
    Route::group([
        'prefix' => 'reference',
    ], function () {
        Route::get('/getKota', function (Request $request) {
            return getKota($request->prov_id);
        });
        Route::get('/getKecamatan', function (Request $request) {
            return getKecamatan($request->kota_id);
        });
        Route::get('/getKelurahan', function (Request $request) {
            return getKelurahan($request->kec_id);
        });

        Route::get('/getIcd9', [ReferenceController::class, 'getIcd9']);
        Route::get('/getIcd10', [ReferenceController::class, 'getIcd10']);

        Route::get('/getPasien', [ReferenceController::class, 'getPasien']);
        Route::get('/getPoli', [ReferenceController::class, 'getPoli']);
        Route::get('/getPoliSub', [ReferenceController::class, 'getPoliSub']);

        Route::get('/getDokter', [ReferenceController::class, 'getDokter']);
        Route::get('/getTindakan', [ReferenceController::class, 'getTindakan']);

        Route::get('/getBarangJenis', [ReferenceController::class, 'getBarangJenis']);
        Route::get('/getBarangkategori', [ReferenceController::class, 'getBarangkategori']);
        Route::get('/getBarangSatuan', [ReferenceController::class, 'getBarangSatuan']);
        Route::get('/getBarang', [ReferenceController::class, 'getBarang']);
        
        Route::post('/getPoliRegistrasi', [ReferenceController::class, 'getPoliRegistrasi']);
        Route::post('/getKasir', [ReferenceController::class, 'getKasir']);
        
    });



    // Route untuk modul registrasi
    Route::group([
        'prefix' => 'registrasi',
    ], function () {
        Route::post('/tableRiwayat', [RegistrasiController::class, 'tableRiwayat']);
    });


    // Route untuk modul assesment
    Route::group([
        'prefix' => 'assesment',
    ], function () {
        Route::get('/poli-umu', function (Request $request) {
            $register = Clinic::getDataRegister($request->id, $request->booking);
            if (!$register) {
                return redirect('/poli-umu');
            } else {
                $poli = PoliUmum::where('registrasi_id', $register->id)->first();
                return view('transaksi.poliumum.form', [
                    'url' => url('/poli-umu/submitData'),
                    'register' => $register,
                    'poli' => $poli,
                ]);
            }
        });

        Route::get('/pasien', function (Request $request) {
            $pasien = Pasien::where('id', $request->id)->first();
            return view('master.pasien.formPreview', [
                'data' => $pasien,
            ]);
        });

        Route::get('/riwayat', [RegistrasiController::class, 'riwayat']);


        Route::get('/attachdata', function (Request $request) {
            $penunjang = PoliPenunjang::where('id', $request->id)
                        ->where('registrasi_id', $request->registrasi_id)
                        ->first();
            $image = glob(public_path('files/penunjang') . "/" . $penunjang->nama_file . "*");
            if (count($image) > 0) {
                header("Content-type: image/jpg");
                $location = $image[0];
                $data = fopen($location, 'rb');
                $size = filesize($location);
                $contents = fread($data, $size);
                fclose($data);
                echo $contents;
            } else {
                return null;
            }
        });
    });
});

Route::group([
    'middleware' => ['auth:sanctum', 'can:Admin', 'verified']
], function () {
    // Group Routes untuk modul yang bisa melakukan insert edit hapus

    // Route untuk modul user
    Route::group([
        'prefix' => 'user',
    ], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/formAdd', [UserController::class, 'formAdd']);
        Route::get('/formEdit', [UserController::class, 'formEdit']);
        Route::post('/tableMain', [UserController::class, 'tableMain']);
        Route::middleware('can:Insert')->post('/insertData', [UserController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [UserController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [UserController::class, 'deleteData']);

        Route::post('/getUserGroup', [UserController::class, 'getUserGroup']);
    });

    // Route untuk modul group
    Route::group([
        'prefix' => 'group',
    ], function () {
        Route::get('/', [GroupController::class, 'index']);
        Route::post('/tableMain', [GroupController::class, 'tableMain']);
        Route::get('/formAdd', [GroupController::class, 'formAdd']);
        Route::get('/formEdit', [GroupController::class, 'formEdit']);

        Route::middleware('can:Insert')->post('/insertData', [GroupController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [GroupController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [GroupController::class, 'deleteData']);

        Route::get('/formPrivilege', [GroupController::class, 'formPrivilege']);
        Route::post('/tablePrivilege', [GroupController::class, 'tablePrivilege']);
        Route::post('/insertGroupAccess', [GroupController::class, 'insertGroupAccess']);
    });

    // Route untuk modul menu
    Route::group([
        'prefix' => 'menu',
    ], function () {
        Route::get('/', [MenuController::class, 'index']);
        Route::post('/tableMain', [MenuController::class, 'tableMain']);
        Route::post('/getMainMenu', [MenuController::class, 'getMainMenu']);
        Route::get('/formAdd', [MenuController::class, 'formAdd']);
        Route::get('/formEdit', [MenuController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [MenuController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [MenuController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [MenuController::class, 'deleteData']);
    });

    // Route untuk modul jenis pegawai
    Route::group([
        'prefix' => 'pegawai-jenis',
    ], function () {
        Route::get('/', [PegawaiJenisController::class, 'index']);
        Route::post('/tableMain', [PegawaiJenisController::class, 'tableMain']);
        Route::get('/formAdd', [PegawaiJenisController::class, 'formAdd']);
        Route::get('/formEdit', [PegawaiJenisController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [PegawaiJenisController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [PegawaiJenisController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [PegawaiJenisController::class, 'deleteData']);
    });

    // Route untuk modul jenis pegawai
    Route::group([
        'prefix' => 'pegawai',
    ], function () {
        Route::get('/', [PegawaiController::class, 'index']);
        Route::post('/tableMain', [PegawaiController::class, 'tableMain']);
        Route::get('/formAdd', [PegawaiController::class, 'formAdd']);
        Route::get('/formEdit', [PegawaiController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [PegawaiController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [PegawaiController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [PegawaiController::class, 'deleteData']);
    });

    // Route untuk modul asuransi
    Route::group([
        'prefix' => 'asuransi',
    ], function () {
        Route::get('/', [AsuransiController::class, 'index']);
        Route::post('/tableMain', [AsuransiController::class, 'tableMain']);
        Route::get('/formAdd', [AsuransiController::class, 'formAdd']);
        Route::get('/formEdit', [AsuransiController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [AsuransiController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [AsuransiController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [AsuransiController::class, 'deleteData']);
    });

    // Route untuk modul cabang
    Route::group([
        'prefix' => 'cabang',
    ], function () {
        Route::get('/', [CabangController::class, 'index']);
        Route::post('/tableMain', [CabangController::class, 'tableMain']);
        Route::get('/formAdd', [CabangController::class, 'formAdd']);
        Route::get('/formEdit', [CabangController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [CabangController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [CabangController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [CabangController::class, 'deleteData']);
    });

    // Route untuk modul poli
    Route::group([
        'prefix' => 'poli',
    ], function () {

        Route::get('/', [PoliController::class, 'index']);
        Route::post('/tableMain', [PoliController::class, 'tableMain']);
        Route::get('/formAdd', [PoliController::class, 'formAdd']);
        Route::get('/formEdit', [PoliController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [PoliController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [PoliController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [PoliController::class, 'deleteData']);

        Route::get('/formSubSpesialis', [PoliController::class, 'formSubSpesialis']);
        Route::post('/tableDetail', [PoliController::class, 'tableDetail']);
        Route::middleware('can:Insert')->post('/submitSubSpesialis', [PoliController::class, 'submitSubSpesialis']);
        Route::middleware('can:Delete')->post('/deleteSubSpesialis', [PoliController::class, 'deleteSubSpesialis']);
    });

    // Route untuk modul pasien
    Route::group([
        'prefix' => 'pasien',
    ], function () {
        Route::get('/', [PasienController::class, 'index']);
        Route::post('/tableMain', [PasienController::class, 'tableMain']);
        Route::get('/formAdd', [PasienController::class, 'formAdd']);
        Route::get('/formEdit', [PasienController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [PasienController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [PasienController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [PasienController::class, 'deleteData']);
    });

    // Route untuk modul tindakan
    Route::group([
        'prefix' => 'tindakan',
    ], function () {
        Route::get('/', [TindakanController::class, 'index']);
        Route::post('/tableMain', [TindakanController::class, 'tableMain']);
        Route::get('/formAdd', [TindakanController::class, 'formAdd']);
        Route::get('/formEdit', [TindakanController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [TindakanController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [TindakanController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [TindakanController::class, 'deleteData']);
    });

    // Route untuk modul barang-satuan
    Route::group([
        'prefix' => 'barang-satuan',
    ], function () {
        Route::get('/', [BarangSatuanController::class, 'index']);
        Route::post('/tableMain', [BarangSatuanController::class, 'tableMain']);
        Route::get('/formAdd', [BarangSatuanController::class, 'formAdd']);
        Route::get('/formEdit', [BarangSatuanController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [BarangSatuanController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [BarangSatuanController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [BarangSatuanController::class, 'deleteData']);
    });

    // Route untuk modul barang-kategori
    Route::group([
        'prefix' => 'barang-kategori',
    ], function () {
        Route::get('/', [BarangKategoriController::class, 'index']);
        Route::post('/tableMain', [BarangKategoriController::class, 'tableMain']);
        Route::get('/formAdd', [BarangKategoriController::class, 'formAdd']);
        Route::get('/formEdit', [BarangKategoriController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [BarangKategoriController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [BarangKategoriController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [BarangKategoriController::class, 'deleteData']);
    });

    // Route untuk modul barang-jenis
    Route::group([
        'prefix' => 'barang-jenis',
    ], function () {
        Route::get('/', [BarangJenisController::class, 'index']);
        Route::post('/tableMain', [BarangJenisController::class, 'tableMain']);
        Route::get('/formAdd', [BarangJenisController::class, 'formAdd']);
        Route::get('/formEdit', [BarangJenisController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [BarangJenisController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [BarangJenisController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [BarangJenisController::class, 'deleteData']);
    });

    // Route untuk modul barang
    Route::group([
        'prefix' => 'barang',
    ], function () {
        Route::get('/', [BarangController::class, 'index']);
        Route::post('/tableMain', [BarangController::class, 'tableMain']);
        Route::get('/formAdd', [BarangController::class, 'formAdd']);
        Route::get('/formEdit', [BarangController::class, 'formEdit']);
        Route::middleware('can:Insert')->post('/insertData', [BarangController::class, 'insertData']);
        Route::middleware('can:Update')->post('/updateData', [BarangController::class, 'updateData']);
        Route::middleware('can:Delete')->post('/deleteData', [BarangController::class, 'deleteData']);
    });

    // Route untuk modul registrasi
    Route::group([
        'prefix' => 'registrasi',
    ], function () {
        Route::get('/', [RegistrasiController::class, 'index']);
        Route::get('/formAdd', [RegistrasiController::class, 'formAdd']);
        Route::post('/tableMain', [RegistrasiController::class, 'tableMain']);
        Route::middleware('can:Insert')->post('/insertData', [RegistrasiController::class, 'insertData']);
        Route::middleware('can:Delete')->post('/batalRegistrasi', [RegistrasiController::class, 'batalRegistrasi']);
    });

    // Route untuk modul poli-umu
    Route::group([
        'prefix' => 'poli-umu',
    ], function () {
        Route::get('/', [PoliUmumController::class, 'index']);

        Route::post('/tableTindakan', [PoliUmumController::class, 'tableTindakan']);
        Route::middleware('can:Insert')->post('/submitTindakan', [PoliUmumController::class, 'submitTindakan']);
        Route::middleware('can:Delete')->post('/deleteDataTindakan', [PoliUmumController::class, 'deleteDataTindakan']);
        
        Route::post('/tableBarang', [PoliUmumController::class, 'tableBarang']);
        Route::middleware('can:Insert')->post('/submitBarang', [PoliUmumController::class, 'submitBarang']);
        Route::middleware('can:Delete')->post('/deleteDataBarang', [PoliUmumController::class, 'deleteDataBarang']);

        Route::post('/tablePenunjang', [PoliUmumController::class, 'tablePenunjang']);
        Route::middleware('can:Insert')->post('/submitPenunjang', [PoliUmumController::class, 'submitPenunjang']);
        Route::middleware('can:Delete')->post('/deleteDataPenunjang', [PoliUmumController::class, 'deleteDataPenunjang']);

        Route::middleware('can:Insert')->post('/submitData', [PoliUmumController::class, 'submitData']);

        Route::post('/getRiwayatPoli', [PoliUmumController::class, 'getRiwayatPoli']);
        
    });

    // Route untuk modul kasir
    Route::group([
        'prefix' => 'kasir',
    ], function () {
        Route::get('/', [KasirController::class, 'index']);
        Route::get('/bayar', [KasirController::class, 'bayar']);
        Route::post('/tablePembayaran', [KasirController::class, 'tablePembayaran']);
        Route::middleware('can:Insert')->post('/submitKasir', [KasirController::class, 'submitKasir']);

        Route::get('/print', [KasirController::class, 'print']);
    });

    // Route untuk modul kunjungan
    Route::group([
        'prefix' => 'kunjungan',
    ], function () {
        Route::get('/', [RptKunjunganController::class, 'index']);
        Route::get('/previewData', [RptKunjunganController::class, 'previewData']);
        Route::get('/printData', [RptKunjunganController::class, 'printData']);
    });

    // Route untuk modul pendapatan
    Route::group([
        'prefix' => 'pendapatan',
    ], function () {
        Route::get('/', [RptPendapatanController::class, 'index']);
        Route::get('/previewData', [RptPendapatanController::class, 'previewData']);
        Route::get('/printData', [RptPendapatanController::class, 'printData']);
    });

    // Route untuk modul trendpenyakit
    Route::group([
        'prefix' => 'trendpenyakit',
    ], function () {
        Route::get('/', [RptTrendPenyakitController::class, 'index']);
        Route::get('/previewData', [RptTrendPenyakitController::class, 'previewData']);
        Route::get('/printData', [RptTrendPenyakitController::class, 'printData']);
    });
});
