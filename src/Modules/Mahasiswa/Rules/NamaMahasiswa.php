<?php namespace Wongpinter\Feeder\Modules\Mahasiswa\Validations;

use Wongpinter\Feeder\Modules\Mahasiswa\Dto\MahasiswaDTOContract;
use Wongpinter\Feeder\Exeptions\RequiredForFeederException;

/**
 * Created By: Sugeng
 * Date: 14/11/19
 * Time: 21.01
 */
class NamaMahasiswa
{
    public static function validate(MahasiswaDTOContract $mahasiswa): string
    {
        if (isEmpty($mahasiswa->nama))
            throw RequiredForFeederException::fromMahasiswa("Nama Mahasiswa", $mahasiswa->no_registrasi_mahasiswa);

        return true;
    }
}
