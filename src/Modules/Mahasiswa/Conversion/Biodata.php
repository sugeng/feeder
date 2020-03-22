<?php namespace Wongpinter\Feeder\Modules\Mahasiswa\Convertion;

use Wongpinter\Feeder\Exeptions\RequiredForFeederException;
use Wongpinter\Feeder\Modules\Mahasiswa\Conversion;
use Wongpinter\Feeder\Modules\Mahasiswa\Validations\NamaMahasiswa;

/**
 * Created By: Sugeng
 * Date: 17/11/19
 * Time: 14.40
 */
class Biodata
{
    public static function nama(Conversion $transform)
    {
        try {
            $nama = NamaMahasiswa::validate($transform->mahasiswa());
        } catch (RequiredForFeederException $e) {

        }
    }
}
