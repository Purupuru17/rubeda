<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $detail['nim'] ?> | <?= $detail['nama_mhs'] ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('app/img/logo.png') ?>"/>
        <style>
            html, .signature{
                font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif;
            }
            td { 
                font-family:Verdana, Arial, Helvetica, sans-serif; 
                font-size: 12px;
            }
            th {
                font-size: 12px;
                text-align: center;
            }
            .watermark {
                background:url(<?= base_url('app/img/logo.png') ?>);
                background-repeat: no-repeat;
                background-position: center center;
                opacity: 0.06;
            }
            .logo{
                width: 70px;
                position: absolute;
                z-index: 1;
                left: 10px;
                top: 0px;
            }
            .red {
                color: #dd5a43 !important 
            }
            .hide {
                display: none;
            }
            .footer{
                position: fixed;
                bottom: 0px;
                font-size: 9px !important;
                border-top: 1px double black;
            }
        </style>
    </head>
    <body class="watermark">
        <table width="100%" style="padding-bottom:10px;margin-bottom:10px;">
            <tbody>
                <tr>
                    <th colspan="4">
                        <font size="2">
                            KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
                        </font>
                        <img src="<?= load_file('app/img/logo.png') ?>" class="logo">
                    </th>
                </tr>
                <tr>
                    <td align="center" colspan="4">
                        <div class="repTitle">
                            <font size="3">
                                <strong>
                                    UNIVERSITAS PENDIDIKAN MUHAMMADIYAH (UNIMUDA) SORONG<br/>
                                    <?= strtoupper($prodi['fakultas']) ?>
                                </strong>
                            </font>
                            <br/>
                            SK. MENRISTEKDIKTI No. 547/KPT/I/2018<br/>
                            Jln. KH. Ahmad Dahlan No. 01 Malawele Aimas Kabupaten Sorong
                            Telp. (0951) 324409, 327873 Fax. (0951) 324409
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="4">
                        <br/>
                        <font size="4"><strong style="text-decoration: underline"><?= $judul[0] ?></strong></font>
                        <br/><br/>
                    </td>
                </tr>
                <tr>
                    <td align="left" width="15%"><strong>Nama Mahasiswa</strong></td>
                    <td align="left" width="45%"><strong>: <?= $detail['nama_mhs'] ?> </strong> </td>
                    <td align="left" width="15%"><strong>NIM</strong></td>
                    <td align="left"><strong>: <?= $detail['nim'] ?> </strong> (<?= $detail['status_mhs'] ?>) </td>
                </tr>
                <tr>
                    <td align="left"><strong>Program Studi</strong></td>
                    <td align="left"><strong>:</strong> <?= $detail['nama_prodi'] ?> </td>
                    <td align="left"><strong>Semester</strong></td>
                    <td align="left"><strong>:</strong> <?= $periode ?> </td>
                </tr>
            </tbody>
        </table>
        
        <!--TABEL KRS-->
        <table class="<?= empty($judul[1]) ? '' : 'hide' ?>" width="100%" border="1|0" style="border-collapse: collapse;">
            <tbody>
                <tr>
                    <th width="5%">No</th>
                    <th>Semester</th>
                    <th width="15%">Status</th>
                    <th width="10%">IPS</th>
                    <th width="10%">IPK</th>
                    <th>SKS Semester</th>
                    <th>SKS Total</th>
                </tr>
                <?php
                foreach ($khs_print['table'] as $key => $value) {
                    ?>
                    <tr>
                        <td align="center"><?= $value[0] ?></td>
                        <td align="center"><?= $value[1] ?></td>
                        <td align="center"><?= $value[2] ?></td>
                        <td align="center"><?= $value[3] ?></td>
                        <td align="center"><?= $value[4] ?></td>
                        <td align="center"><?= $value[5] ?></td>
                        <td align="center"><?= $value[6] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <!--TABEL KHS-->
        <table class="<?= empty($judul[1]) ? 'hide' : '' ?>" width="100%" border="1|0" style="border-collapse: collapse;">
            <tbody>
                <tr>
                    <th rowspan="2" width="5%">No</th>
                    <th rowspan="2" width="10%">Kode MK</th>
                    <th rowspan="2">Nama Mata Kuliah</th>
                    <th rowspan="2" width="10%">Bobot MK<br>(sks)</th>
                    <th colspan="2" width="15%">Nilai</th>
                    <th rowspan="2" width="10%">sks * Indeks</th>
                </tr>
                <tr>
                    <th>Huruf</th>
                    <th>Indeks</th>
                </tr>
                <?php
                foreach ($khs_print['table'] as $key => $value) {
                    ?>
                    <tr>
                        <td align="center"><?= $value[0] ?></td>
                        <td align="center"><?= $value[2] ?></td>
                        <td align="left"><?= $value[3] ?></td>
                        <td align="center"><?= $value[4] ?></td>
                        <td align="center"><?= $value[5] ?></td>
                        <td align="center"><?= $value[6] ?></td>
                        <td align="center"><?= $value[7] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Jumlah</th>
                    <th><?= $khs_print['sks'] ?></td>
                    <th colspan="2"></th>
                    <th><?= $khs_print['indeks'] ?></th>
                </tr>
                <tr>
                    <th colspan="6"><?= $judul[1] ?></th>
                    <th><font size="2"><?= $khs_print['ipk'] ?></font></th>
                </tr>
            </tfoot>
        </table>
        
        <table width="100%" style="padding-top: 30px">
            <tbody>
                <tr>
                    <td colspan="2"></td>
                    <td align="center" width="40%" style="font-size: 13px">
                        Sorong, <?= format_date(date('Y-m-d'),1) ?> <br/>
                        <strong>Ketua Program Studi <br/> <?= $detail['nama_prodi'] ?></strong>
                        <br/><br/><br/><br/><br/><br/><br/>
                        <strong style="text-decoration: underline"><?= $prodi['ketua_prodi'] ?></strong><br/>
                        NIDN. <?= $prodi['nidn_prodi'] ?>
                    </td>
                    <td width="15%"></td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <table>
                <tr>
                    <td><img src="<?= load_file('app/img/bsi.png') ?>" style="max-width: 40px;padding-right: 5px"></td>
                    <td><?= $this->session->userdata('name') . '<br>' . format_date(date('Y-m-d H:i:s'), 0) . ' @ ' . ip_agent() ?></td>
                </tr>
            </table>
        </div>
    </body>
</html>