<?php namespace Wongpinter\Feeder\Http\Controllers;

use App\Http\Controllers\Controller;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use Wongpinter\Feeder\Models\Base;

/**
 * Created By: Sugeng
 * Date: 2019-08-13
 * Time: 22:56
 */
class FeederController extends Controller
{
    public function tables(Base $feeder)
    {

        return response()->json([
            'status' => 'success',
            'data'   => $feeder->tables()
        ]);
    }

    public function dictionary(Base $feeder, $table)
    {
        return response()->json([
            'status' => 'success',
            'data'   => $feeder->table($table)->dictionary()
        ]);
    }

    public function records(Base $feeder, $table, $limit = 25)
    {
        return $feeder->table($table)->paginate($limit);
    }

    public function saveRecords(Base $feeder)
    {
        $offset_num = 1;
        $header = ['id_wilayah', 'id_negara', 'nama_wilayah', 'asal_wilayah', 'id_induk_wilayah', 'id_level_wilayah'];

        $csv = Writer::createFromPath(storage_path('wilayah.csv'), 'w+');
        try {
            $csv->insertOne($header);
        } catch (CannotInsertRecord $e) {
        }

        while (true) {
            $offset = ($offset_num-1) * 100;
            $data = $feeder->table('wilayah')->paginate(100, $offset);
            $offset_num++;
            if (count($data['records']) > 0) {
                foreach($data['records'] as $row) {
                    $csv->insertOne([
                        $row['id_wil'], $row['id_negara'], $row['nm_wil'], $row['asal_wil'], $row['id_induk_wilayah'], $row['id_level_wil']
                    ]);
                }

                dump($data['offset']);
            } else {
                return false;
            }
        }
    }
}
