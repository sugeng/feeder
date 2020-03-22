<?php namespace Wongpinter\Feeder\Commands\Synchronizations;

use Illuminate\Console\Command;
use Larapie\DataTransferObject\Exceptions\ValidatorException;
use Wongpinter\Feeder\Contracts\FeederDataSource;
use Wongpinter\Feeder\Modules\Mahasiswa\Transfer;

/**
 * Created By: Sugeng
 * Date: 2019-08-17
 * Time: 17:24
 */
class Mahasiswa extends Command
{
    protected $signature = "feeder:sync:mahasiswa {mode} {angkatan} {jurusan} {--nim=}";

    protected $description = "Transfer & synchronisasi master mahasiswa dengan program Feeder. 
                                    Gunakan Mode {insert} untuk menambah data mahasiswa baru dan {update} untuk mengupdate data mahasiswa";

    protected $source;
    /**
     * @var Transfer
     */
    protected $transfer;

    public function __construct(
        FeederDataSource $source,
        Transfer $transfer
    )
    {
        parent::__construct();

        $this->source = $source;
        $this->transfer = $transfer;
    }

    public function handle()
    {
        $mahasiswa = $this->source->get($this->parameters())->toArray();

        //$cast_mahasiswa = $this->transfer->from($mahasiswa)->toArray();

        dd($this->toDto($mahasiswa));
    }

    protected function toDto(array $mahasiswa)
    {
        $mahasiswa_dto = null;

        try {
           $mahasiswa_dto = $this->transfer->from($mahasiswa)->toArray();
        } catch (\InvalidArgumentException $e) {
            dump($e->getMessage());
        }

        return $mahasiswa_dto;

    }

    protected function parameters(): array
    {
        return [
            'angkatan' => $this->argument('angkatan'),
            'jurusan'  => $this->argument('jurusan'),
            'nim'      => ($this->option('nim')) ?? null
        ];
    }
}
