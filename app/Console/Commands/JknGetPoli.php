<?php

namespace App\Console\Commands;

use App\CustomClass\Bpjs;
use App\Models\Poli;
use App\Models\PoliSub;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class JknGetPoli extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jkn:getpoli';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengambil data poli';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bpjs = new Bpjs();
        $res = $bpjs->getDataPoli();
        $this->info(date('Y-m-d H:i:s') . '::Mengambil data poli');
        if (json_decode($res)) {
            $json = json_decode($res);
            if ($json->metadata->message == 'OK') {
                $array = $bpjs->decompress($bpjs->stringDecrypt($json->response));
                if ($array && json_decode($array)) {
                    $this->info(date('Y-m-d H:i:s') . '::Update data poli dan subspesialis');
                    $this->submitPoli(json_decode($array));
                } else {
                    $this->info(date('Y-m-d H:i:s') . '::' . ("Proses decrypt gagal, silahkan hubungi IT Anda"));
                }
            } else {
                $this->info(date('Y-m-d H:i:s') . '::' . ($res));
            }
        } else {
            $this->info(date('Y-m-d H:i:s') . '::' . ($res));
        }
    }

    private function submitPoli($array)
    {
        foreach ($array as $val) {
            $poli = Poli::where(DB::raw('lower(kode)'), strtolower($val->kdpoli))->first();
            if ($poli) {
                // Update data poli
                Poli::where('id', $poli->id)->update([
                    'kode'          => $val->kdpoli,
                    'kode_sms'      => $val->kdpoli,
                    'nama'          => strtoupper($val->nmpoli),
                ]);
                $this->submitSubSpesialis($poli->id, $val);
            }else{
                $poli = Poli::create([
                    'kode'          => $val->kdpoli,
                    'kode_sms'      => $val->kdpoli,
                    'nama'          => strtoupper($val->nmpoli),
                    'stat'          => (strtoupper($val->nmpoli)=='UMUM') ? 'Aktif' : 'Tidak',
                ]);
                $this->submitSubSpesialis($poli->id, $val);
            }
        }
    }

    private function submitSubSpesialis($id, $val)
    {
        $subspesialis = PoliSub::where(DB::raw('lower(kode)'), strtolower($val->kdsubspesialis))->first();
        if ($subspesialis) {
            // Update data poli
            PoliSub::where('id', $subspesialis->id)->update([
                'poli_id'       => $id,
                'kode'          => $val->kdsubspesialis,
                'nama'          => strtoupper($val->nmsubspesialis),
            ]);
        }else{
            PoliSub::create([
                'poli_id'       => $id,
                'kode'          => $val->kdsubspesialis,
                'nama'          => strtoupper($val->nmsubspesialis),
                'stat'          => 'Aktif',
            ]);
        }
    }
}
