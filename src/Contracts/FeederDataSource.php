<?php namespace Wongpinter\Feeder\Contracts;
/**
 * Created By: Sugeng
 * Date: 17/11/19
 * Time: 16.26
 */
interface FeederDataSource
{
    public function get($parameter);

    public function toArray();
}
