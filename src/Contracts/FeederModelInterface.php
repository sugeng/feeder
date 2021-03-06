<?php namespace Wongpinter\Feeder\Contracts;
/**
 * Created By: Sugeng
 * Date: 04/04/20
 * Time: 19.19
 */
interface FeederModelInterface
{
    public function get();

    public function first();

    public function insert($data);

    public function update($key, $data);

    public function insertBatch($data);

    public function updateBatch($data);

    public function filter($filter);

    public function search($filter);
}
