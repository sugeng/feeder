<?php namespace Wongpinter\Feeder\Supports;
/**
 * Created By: Sugeng
 * Date: 14/11/19
 * Time: 12.36
 */
class EmptyValue
{
    public static function check($value): bool {
        $checking_value = trim($value);

        if (!empty($checking_value))
            return false;

        if ($checking_value !== '')
            return false;

        if (! is_null($checking_value))
            return false;

        return true;
    }
}
