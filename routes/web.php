<?php
/**
 * Created By: Sugeng
 * Date: 2019-07-15
 * Time: 23:37
 */

Route::get("kelas-kuliah/{tahun_semester}/{kode_jurusan}", function (\Wongpinter\Feeder\Models\KelasKuliah $kelasKuliah, \Wongpinter\Feeder\Models\Nilai $nilai, $tahun_semester, $kode_jurusan) {

    $jadwal = DB::select(DB::raw("
        SELECT j.kdkmk, j.seksi, j.nimhs, j.nlakh, j.nlfin, m.id_reg_pd, l.bobot FROM trsek j
        LEFT OUTER JOIN msmhs m ON m.nimhs=j.nimhs
        LEFT OUTER JOIN tbbnl l ON l.kdkur=m.kdkur AND j.nlakh=l.grade
        WHERE j.thsms='{$tahun_semester}' AND j.kdjur='{$kode_jurusan}'
        ORDER BY j.kdkmk, j.seksi, j.nimhs
    "));

    $jurusan = DB::table('tbjur')->where('kdjur', $kode_jurusan)->first();

    $data = [];
    foreach ($jadwal as $item) {
        $data["{$item->kdkmk}.{$item->seksi}"][] = [
            'id_reg_pd'    => $item->id_reg_pd,
            'nilai_angka'  => $item->nlfin,
            'nilai_huruf'  => $item->nlakh,
            'nilai_indeks' => $item->bobot,
            'nimhs'        => $item->nimhs
        ];
    }

    foreach ($data as $_kelas => $rows) {
        list($kdkmk, $seksi) = explode('.', $_kelas);

        $filter = "p.id_sms = '{$jurusan->id_sms}' AND p.id_smt='20182' AND kode_mk='{$kdkmk}' AND nm_kls='{$seksi}'";

        $data = $kelasKuliah->filter($filter)->first();

        if (!isset($data['id_kls'])) {
            $mk             = DB::table('tbkmk')->where('kdkmk', $kdkmk)->first();
            $kelas_transfer = [
                'id_sms'       => $jurusan->id_sms,
                'id_smt'       => $tahun_semester,
                'nm_kls'       => $seksi,
                'id_mk'        => $mk->id_mk,
                'sks_mk'       => $mk->sksmk,
                'sks_tm'       => $mk->sksmk,
                'sks_prak'     => 0,
                'sks_prak_lap' => 0,
                'sks_sim'      => 0
            ];

            $created_kelas = $kelasKuliah->insert($kelas_transfer);
            if (isset($created_kelas['result']['id_kls'])) {
                $data['id_kls'] = $created_kelas['result']['id_kls'];
                dump("created new Class {$kdkmk} {$seksi} >> {$data['id_kls']}");
            } else {
                dump($created_kelas, $kelas_transfer);
            }
        }

        $transfer_data = [];
        if (sizeof($data) > 0) {
            foreach ($rows as $row) {
                $transfer_data[] = [
                    'id_kls'       => $data['id_kls'],
                    'id_reg_pd'    => $row['id_reg_pd'],
                    'nilai_angka'  => $row['nilai_angka'],
                    'nilai_huruf'  => $row['nilai_huruf'],
                    'nilai_indeks' => $row['nilai_indeks']
                ];
            }
        } else {
            //Log::info("Tidak ditemukan kelas {$kdkmk}, seksi {$seksi}", $rows);
            File::append(storage_path("error.jadwal1.{$kode_jurusan}.json"), [
                'error' => "Tidak ditemukan kelas {$kdkmk}, seksi {$seksi}", 'data' => $rows
                ] . "\r\n");
        }

        dump("Proccess {$kdkmk} Seksi {$seksi} Total: " . count($transfer_data));

        $response = $nilai->insertBatch($transfer_data);

        if ($response['error_code'] <= 0) {
            $index = 0;
            foreach ($response['result'] as $result) {
                if ($result['error_code'] > 0) {
                    if ($result['error_code'] == 118) {
                        $err = json_encode([
                            'nimhs' => $rows[$index]['nimhs'],
                            'kdkmk' => [$kdkmk, $seksi],
                            'data'  => $rows[$index],
                            'desc'  => $result
                        ]);

                        $unix_timestamp = time();
                        File::append(storage_path("error1.{$kode_jurusan}.ext.json"), $err . "\r\n");
                    }
                }
                $index++;
            }
        }
    }
});
