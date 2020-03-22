<?php
/**
 * Created By: Sugeng
 * Date: 14/11/19
 * Time: 12.57
 */

if (! function_exists('isEmpty')) {
    function isEmpty($value) {
        return \Wongpinter\Feeder\Supports\EmptyValue::check($value);
    }
}
