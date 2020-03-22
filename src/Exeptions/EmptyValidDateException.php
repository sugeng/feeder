<?php namespace Wongpinter\Feeder\Exeptions;

use InvalidArgumentException as InvalidArgumentExceptionAlias;

/**
 * Created By: Sugeng
 * Date: 14/11/19
 * Time: 20.55
 */
class EmptyValidDateException extends InvalidArgumentExceptionAlias
{
    public static function fromMahasiswa($field, $nim, $code = 0, Exception $previous = null)
    {
        $message = sprintf(
            'Mahasiswa N.I.M "%s" data "%s" tidak valid', $nim, $field
        );

        return new static($message, $code, $previous);
    }
}
