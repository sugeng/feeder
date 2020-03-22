<?php namespace Wongpinter\Feeder\Contracts;
/**
 * Created By: Sugeng
 * Date: 15/12/19
 * Time: 10.29
 */
interface MahasiswaSource
{
    public function getForFeeder(string $angkatan, string $jurusan, string $nim = null);
}
