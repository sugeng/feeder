<?php namespace Wongpinter\Feeder\Modules\Mahasiswa;

/**
 * Created By: Sugeng
 * Date: 17/11/19
 * Time: 14.30
 */
class Conversion
{
    protected $fields = [
        'id_pd'                         => '',
        'nm_pd'                         => '',
        'jk'                            => '',
        'jln'                           => '',
        'rt'                            => '',
        'rw'                            => '',
        'nm_dsn'                        => '',
        'ds_kel'                        => '',
        'kodepos'                       => '',
        'nisn'                          => '',
        'nik'                           => '',
        'tmpt_lahir'                    => '',
        'tgl_lahir'                     => '',
        'nm_ayah'                       => '',
        'tgl_lahir_ayah'                => '',
        'nik_ayah'                      => '',
        'id_jenjang_pendidikan_ayah'    => '',
        'id_pekerjaan_ayah'             => '',
        'id_penghasilan_ayah'           => '',
        'id_kebutuhan_khusus_ayah'      => '',
        'nm_ibu_kandung'                => '',
        'tgl_lahir_ibu'                 => '',
        'nik_ibu'                       => '',
        'id_jenjang_pendidikan_ibu'     => '',
        'id_pekerjaan_ibu'              => '',
        'id_penghasilan_ibu'            => '',
        'id_kebutuhan_khusus_ibu'       => '',
        'nm_wali'                       => '',
        'tgl_lahir_wali'                => '',
        'id_jenjang_pendidikan_wali'    => '',
        'id_pekerjaan_wali'             => '',
        'id_penghasilan_wali'           => '',
        'id_kk'                         => '0',
        'no_tel_rmh'                    => '',
        'no_hp'                         => '',
        'email'                         => '',
        'a_terima_kps'                  => 0,
        'no_kps'                        => '',
        'npwp'                          => '',
        'id_wil'                        => '',
        'id_jns_tinggal'                => '',
        'id_agama'                      => '',
        'id_alat_transport'             => 1,
        'kewarganegaraan'               => 'ID',
    ];

    public function fill(array $fields)
    {
        array_merge($fields, $this->fields);
    }
}
