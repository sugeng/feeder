<?php namespace Wongpinter\Feeder\Modules\Mahasiswa\Dto;

use Larapie\DataTransferObject\DataTransferObject;
/**
 * Created By: Sugeng
 * Date: 17/11/19
 * Time: 11.51
 */
abstract class MahasiswaDTO extends DataTransferObject implements MahasiswaDTOContract
{
    /** @var string */
    public $nama;

    /** @var string */
    public $no_registrasi_mahasiswa;

    /** @var string */
    public $jenis_kelamin;

    /** @var string|null */
    public $alamat;

    /** @var string|null */
    public $no_rt;

    /** @var string|null */
    public $no_rw;

    /** @var string|null */
    public $nama_kecamatan;

    /** @var string|null */
    public $nama_kelurahan;

    /** @var string|null */
    public $kode_pos;

    /** @var string|null */
    public $nisn;

    /** @var string */
    public $nik;

    /** @var string|null */
    public $tempat_lahir;

    public $tanggal_lahir;

    /** @var string */
    public $nama_ayah;

    /** @var string|null */
    public $tanggal_lahir_ayah;

    /** @var string */
    public $nik_ayah;

    /** @var string */
    public $jenjang_pendidikan_ayah;

    /** @var string */
    public $pekerjaan_ayah;

    /** @var string|null */
    public $penghasilan_ayah;

    /** @var int */
    public $kebutuhan_khusus_ayah;

    /** @var string */
    public $nama_ibu;

    /** @var string */
    public $nik_ibu;

    /** @var string|null */
    public $tanggal_lahir_ibu;

    /** @var string */
    public $jenjang_pendidikan_ibu;

    /** @var string */
    public $pekerjaan_ibu;

    /** @var string|null */
    public $penghasilan_ibu;

    /** @var int */
    public $kebutuhan_khusus_ibu;

    /** @var string|null */
    public $no_kartu_keluarga;

    /** @var string */
    public $no_telepon;

    /** @var string */
    public $no_ponsel;

    /** @var string */
    public $email;

    /** @var string */
    public $penerima_kps;

    /** @var string */
    public $no_kps;

    /** @var string|null */
    public $npwp;

    /** @var string|null */
    public $kode_propinsi;

    /** @var string */
    public $jenis_tinggal;

    /** @var string */
    public $agama;

    /** @var string */
    public $transportasi;

    /** @var string */
    public $kewarganegaraan;
}
