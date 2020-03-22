<?php namespace Wongpinter\Feeder\Modules\Mahasiswa\Rules;

use Wongpinter\Feeder\Exeptions\RequiredForFeederException;
use Wongpinter\Feeder\Modules\Mahasiswa\Dto\MahasiswaDTOContract;

/**
 * Created By: Sugeng
 * Date: 14/11/19
 * Time: 20.21
 */
class NamaIbu
{
    public static function validate(MahasiswaDTOContract $mahasiswa): string
    {
        if (isEmpty($mahasiswa->nama_ibu))
            throw RequiredForFeederException::fromMahasiswa("Nama Ibu", $mahasiswa->no_registrasi_mahasiswa);

        return true;
    }
}
