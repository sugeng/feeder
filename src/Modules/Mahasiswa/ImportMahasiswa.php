<?php namespace Wongpinter\Feeder\Modules\Mahasiswa;

use Maatwebsite\Excel\Concerns\ToArray;

/**
 * Created By: Sugeng
 * Date: 26/11/19
 * Time: 13.33
 */
class ImportMahasiswa implements ToArray
{
    /**
     * @param array $array
     * @return array
     */
    public function array(array $array)
    {
        return [
            'nim_mahasiswa'
        ];
    }
}
