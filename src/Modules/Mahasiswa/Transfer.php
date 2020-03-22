<?php namespace Wongpinter\Feeder\Modules\Mahasiswa;

use Wongpinter\Feeder\Modules\Mahasiswa\Dto\MahasiswaCollectionContract;
use Wongpinter\Feeder\Modules\Mahasiswa\Dto\MahasiswaDTOContract;
use Wongpinter\Feeder\Supports\ErrorLogging;

/**
 * Created By: Sugeng
 * Date: 17/11/19
 * Time: 14.00
 */
class Transfer
{
    /**
     * @var MahasiswaCollectionContract
     */
    protected $collection;

    protected $mahasiswa;

    protected $errors;

    protected $mahasiwa;
    /**
     * @var Convertion
     */
    protected $fields;

    public function __construct(MahasiswaCollectionContract $collection)
    {
        $this->collection = $collection;
        $this->errors     = new ErrorLogging();
        $this->fields     = new Conversion();
    }

    public function from(array $mahasiswa)
    {
        $this->mahasiswa = $this->collection->create($mahasiswa);

        return $this->mahasiswa;
    }

    public function mahasiswa(): MahasiswaDTOContract
    {
        return $this->mahasiswa;
    }

    public function errors(): ErrorLogging
    {
        return $this->errors;
    }

    public function fill(array $data)
    {
        return $this->fields->fill($data);
    }
}
