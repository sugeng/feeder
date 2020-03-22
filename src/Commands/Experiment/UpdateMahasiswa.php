<?php namespace Wongpinter\Feeder\Commands\Experiment;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Wongpinter\Feeder\Models\Mahasiswa as MahasiswaFeeder;
use Wongpinter\Feeder\Models\MahasiswaPt;
use Wongpinter\Feeder\Modules\Mahasiswa\ImportMahasiswa;

/**
 * Created By: Sugeng
 * Date: 26/11/19
 * Time: 13.26
 */
class UpdateMahasiswa extends Command
{
    protected $signature = "feeder:import";

    public function __construct()
    {
        parent::__construct();
    }

    public function nik(MahasiswaFeeder $mahasiswaFeeder, MahasiswaPt $mahasiswaPt)
    {
        $mahasiswa_csv = \DB::table("msmhs")->whereRaw("left(nimhs, 4) IN ('2015', '2016', '2017', '2018')")->whereRaw("kdjur IN ('21', '22', '41', '01', '02', '03')")->get();
        #$mahasiswa_csv = $this->readCsv();

        foreach ($mahasiswa_csv as $m) {
            if (!empty($m->id_reg_pd) && !empty($m->nonik)) {

                $m_fed = $mahasiswaPt->filter("id_reg_pd='{$m->id_reg_pd}'")->first();


                $key = [
                    'id_pd' => $m_fed['id_pd']
                ];

                $data = [
                    'nik' => $m->nonik
                ];

                $resp = $mahasiswaFeeder->update($key, $data);

                dump($key, $data, $resp);
            }
        }
    }

    public function handle(MahasiswaPt $mahasiswaPt, MahasiswaFeeder $mahasiswaFeeder)
    {
        $this->nik($mahasiswaFeeder, $mahasiswaPt);

//        $mahasiswa_csv = $this->readCsv();
//
//        $feeder_import = [];
//
//        foreach ($mahasiswa_csv as $worksheet_number => $worksheet) {
//            $total_data = count($worksheet);
//            $this->info("Proccessing sheet {$worksheet_number} Total data {$total_data}");
//
//            foreach ($worksheet as $row) {
//                $mahasiswa = \DB::table("msmhs")->where('nimhs', trim($row[0]))->first();
//
//                if ($mahasiswa) {
//                    if (!empty($mahasiswa->id_reg_pd)) {
//                        if (empty($mahasiswa->noijz)) {
//                            $mahasiswa->noijz = "999/999/999";
//                            //\File::append(storage_path("error.31.no_ijz.json"), json_encode([$mahasiswa->nimhs]) . "\r\n");
//                        }
//
//                        $key = [
//                            'id_reg_pd' => $mahasiswa->id_reg_pd
//                        ];
//
//                        $data = $this->dataFeeder($mahasiswa);
//
//                        $resp = $mahasiswaPt->update($key, $data);
//
//                        dump($data);
//                        dump($resp);
//
//                        $feeder_import[] = [
//                            'key' => $key,
//                            'data' => $data
//                        ];
//                        //dd($mahasiswa->nimhs, $feeder_import);
//                    } else {
//                        $err = json_encode([
//                            "NIM" => $mahasiswa->nimhs,
//                            "ERROR" => "Tidak memiliki REG ID FEEDER"
//                        ]);
//                        $this->error("Error Mahasiswa {$mahasiswa->nimhs}");
//                        File::append(storage_path("error.lulusan.json"), $err . "\r\n");
//                    }
//                }
//            }
//        }

//        $total_data = count($feeder_import);
//        $response = []; $i=0; $proccessed = 0;
//        foreach (array_chunk($feeder_import, 250) as $rows) {
//
//            foreach ($rows as $feeder) {
//                //dump($feeder);
//                $response = $mahasiswaPt->updateBatch($feeder);
//                //dump($response);
//                $proccessed++;
//            }
//
//            $this->info("Updating {$proccessed} from {$total_data} mahasiswa");
//
////            foreach ($response['result'] as $res) {
////                dump($res);
////            }
       // }
    }

    protected function readCsv()
    {
        $path = \Storage::disk('local')->path('SKG.csv');

        $data = Excel::toArray(new ImportMahasiswa, $path);

        return $data;
    }

    protected function dataFeeder($data)
    {
        //$bulan_bimbingan = $this->calculateTanggalBimbingan($this->parameter->tahun_semester);
        if ($data->tglre == '0000-00-00')
            $data->tglre = '1990-01-01';

        if (is_null($data->tglre))
            $data->tglre = '1990-01-01';

        if ($data->tglls == '0000-00-00')
            $data->tglls = '1990-01-01';

        if (is_null($data->tglls))
            $data->tglls = '1990-01-01';

        return [
            'tgl_keluar'            => (!is_null($data->tglls) or $data->tglls !== '0000-00-00') ? $data->tglls : '1990-01-01',
            'id_jns_keluar'         => "1",
            'ket'                   => '',
            'sk_yudisium'           => (!empty($data->noskr)) ? trim($data->noskr) : "99/99/99/99",
            'tgl_sk_yudisium'       => (!is_null($data->tglre) or $data->tglre !== '0000-00-00' ) ? $data->tglre : "1990-01-01",
            'ipk'                   => (!empty($data->nlipk)) ? $data->nlipk : '2.50',
            'no_seri_ijazah'        => trim($data->noijz),
            'jalur_skripsi'         => "1",
            'judul_skripsi'         => (!empty($data->judul)) ? trim($data->judul) : "ISI SKRIPSI",
            //'bln_awal_bimbingan'    => $bulan_bimbingan['bln_awal_bimbingan'],
            //'bln_akhir_bimbingan'   => $bulan_bimbingan['bln_akhir_bimbingan']
        ];
    }

    private function calculateTanggalBimbingan($tahun_semester)
    {
        $tahun    = substr($tahun_semester, 0, 4);
        $semester = substr($tahun_semester, -1, 1);

        $tanggal_awal_bimbingan = $tanggal_akhir_bimbingan = '';
        if ($semester == 2) {
            $tanggal_awal_bimbingan     = "{$tahun}-09-01";
            $tanggal_akhir_bimbingan    = ($tahun + 1) . "-02-28";
        } else if ($semester == 1) {
            $tanggal_awal_bimbingan     = ($tahun - 1) . "-03-01";
            $tanggal_akhir_bimbingan    = ($tahun) . "-08-31";
        }

        return [
            'bln_awal_bimbingan' => $tanggal_awal_bimbingan,
            'bln_akhir_bimbingan' => $tanggal_akhir_bimbingan
        ];
    }
}
