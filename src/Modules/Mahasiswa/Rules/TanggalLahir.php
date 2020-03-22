<?php namespace Wongpinter\SimpatiFeeder\Modules\Mahasiswa\Validations;

use Wongpinter\Feeder\Exeptions\EmptyValidDateException;
use Wongpinter\Feeder\Exeptions\RequiredForFeederException;
use Wongpinter\Feeder\Modules\Mahasiswa\Dto\MahasiswaDTOContract;

/**
 * Created By: Sugeng
 * Date: 14/11/19
 * Time: 20.25
 */
class TanggalLahir
{
    public static function validate(MahasiswaDTOContract $mahasiswa)
    {
        self::ValidateEmptyDate($mahasiswa);

        self::validDateFormat($mahasiswa);

        return true;
    }

    /**
     * @param $mahasiswa
     */
    private static function validDateFormat(MahasiswaDTOContract $mahasiswa): void
    {
        list($year, $month, $day) = explode('-', $mahasiswa->tanggal_lahir);

        if (!checkdate($month, $day, $year))
            throw EmptyValidDateException::fromMahasiswa("Tanggal Lahir", $mahasiswa->no_registrasi_mahasiswa);
    }

    /**
     * @param $mahasiswa
     */
    private static function ValidateEmptyDate($mahasiswa): void
    {
        if (isEmpty($mahasiswa->tanggal_lahir))
            throw RequiredForFeederException::fromMahasiswa("Tanggal Lahir", $mahasiswa->no_registrasi_mahasiswa);
    }
}
