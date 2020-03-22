<?php namespace Wongpinter\Feeder\Modules\Mahasiswa\Transform;

use Wongpinter\Feeder\Exeptions\RequiredForFeederException;
use Wongpinter\Feeder\Modules\Mahasiswa\Transfer;
use Wongpinter\Feeder\Modules\Mahasiswa\Validations\NamaMahasiswa;
use Wongpinter\SimpatiFeeder\Modules\Mahasiswa\Validations\TanggalLahir;

/**
 * Created By: Sugeng
 * Date: 19/11/19
 * Time: 12.21
 */
class Biodata
{
    /**
     * @var \Wongpinter\Feeder\Modules\Mahasiswa\Dto\MahasiswaDTOContract
     */
    protected $mahasiswa;

    /**
     * @var \Wongpinter\Feeder\Supports\ErrorLogging
     */
    protected $errorBag;
    /**
     * @var Transfer
     */
    protected $transfer;

    protected $fields = [
        ""
    ];


    public function __construct(Transfer $transfer)
    {
        $this->transfer  = $transfer;
        $this->mahasiswa = $transfer->mahasiswa();
        $this->errorBag  = $transfer->errors();
    }

    public function run()
    {
        foreach ($this->fields as $field) {
            $this->{$field};
        }
    }

    protected function nama()
    {
        try {
            NamaMahasiswa::validate($this->mahasiswa);
        } catch (RequiredForFeederException $e) {
            $this->errorBag->addRequired($e->getMessage());
        }

        return $this->transfer->fill(["nm_pd" => trim($this->mahasiswa->nama)]);
    }

    protected function jenisKelamin()
    {

    }

    protected function agama()
    {

    }

    protected function nisn()
    {

    }

    protected function nik()
    {

    }

    protected function tanggalLahir()
    {
        try {
            TanggalLahir::validate($this->mahasiswa);
        } catch (RequiredForFeederException $e) {
            $this->errorBag->addRequired($e->getMessage());
        }
    }

    protected function tempatLahir()
    {

    }

    protected function jenisTinggal()
    {

    }

    protected function transportasi()
    {

    }

    protected function kewarganegaraan()
    {

    }
}
