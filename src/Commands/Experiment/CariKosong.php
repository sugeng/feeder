<?php namespace Wongpinter\Feeder\Commands\Experiment;

use File;
use Illuminate\Console\Command;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use Maatwebsite\Excel\Facades\Excel;
use Wongpinter\Feeder\Modules\Mahasiswa\ImportMahasiswa;

/**
 * Created By: Sugeng
 * Date: 17/12/19
 * Time: 10.14
 */
class CariKosong extends Command
{
    protected $signature = "feeder:kosong";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $mahasiswa_csv = $this->readCsv();

        $header = ['NIM', 'Nama Mahasiswa', 'Status'];

        $csv = Writer::createFromPath(storage_path('data_mahasiswa_ijazah_kosong_SKG.csv'), 'w+');

        try {
            $csv->insertOne($header);
        } catch (CannotInsertRecord $e) {
        }

        foreach ($mahasiswa_csv as $worksheet_number => $worksheet) {
            $total_data = count($worksheet);
            $this->info("Proccessing sheet {$worksheet_number} Total data {$total_data}");

            foreach ($worksheet as $row) {
                $mahasiswa = \DB::table("msmhs")->where('nimhs', trim($row[0]))->first();

                if ($mahasiswa) {
                    $this->info("Processing {$mahasiswa->nimhs}");

                    if (!empty($mahasiswa->id_reg_pd)) {
                        if (empty($mahasiswa->noijz)) {
                            try {
                                $csv->insertOne([
                                    $mahasiswa->nimhs, $mahasiswa->nmmhs, $mahasiswa->stakl
                                ]);
                            } catch (CannotInsertRecord $e) {
                            }
                        }
                    } else {
                        $err = json_encode([
                            "NIM" => $mahasiswa->nimhs,
                            "ERROR" => "Tidak memiliki REG ID FEEDER"
                        ]);
                        $this->error("Error Mahasiswa {$mahasiswa->nimhs}");
                        File::append(storage_path("error.lulusan.json"), $err . "\r\n");
                    }
                }
            }
        }
    }

    protected function readCsv()
    {
        $path = \Storage::disk('local')->path('SKG.csv');

        return Excel::toArray(new ImportMahasiswa, $path);
    }
}
