<?php namespace Wongpinter\SimpatiFeeder\Modules\Mahasiswa\Validations;

use Wongpinter\Feeder\Modules\Mahasiswa\Dto\MahasiswaDTOContract;
use Wongpinter\Feeder\Exeptions\RequiredForFeederException;

/**
 * Created By: Sugeng
 * Date: 14/11/19
 * Time: 21.00
 */
class TempatLahir
{
    public function validate(MahasiswaDTOContract $mahasiswa): string
    {
        if (isEmpty($mahasiswa->tempat_lahir))
            throw RequiredForFeederException::fromMahasiswa("Tempat Lahir", $mahasiswa->no_registrasi_mahasiswa);

        return true;
    }
}
