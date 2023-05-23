<?php $this->load->view('sistem/v_breadcrumb'); ?>
<style>
    .profile-info-name{
        width: 160px;
    }
    th,td{
        text-align: center;
    }
</style>
<div class="page-content">
    <div class="page-header">
        <h1>
            <?= $title[1] ?>
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                <?= $title[0] ?>
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <?= $this->session->flashdata('notif'); ?>
        </div>
        <div class="col-xs-12">
            <div class="widget-box transparent">
                <div class="widget-header">
                    <h4 class="widget-title lighter bolder">
                        <?= $title[1] ?>
                        <?= empty(element('pass_mhs', $akun, '')) ? '' : '<i class="fa fa-check-circle-o bigger-120 green"></i>' ?>
                    </h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse" class="orange2">
                            <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                        </a>
                    </div>
                    <div class="widget-toolbar no-border">
                        <div class="btn-group btn-overlap">
                            <a target="_blank" href="<?= site_url($module.'/add/'. encode($detail['id_mhs'])) ?>" 
                               class="btn btn-white btn-success btn-sm btn-bold <?= (!in_array($detail['status_mhs'], array('AKTIF'))) ? 'hide' : '' ?>">
                                <i class="fa fa-user-plus bigger-120"></i> Buat Akun
                            </a>
                            <button id="btn-bio" class="btn btn-white btn-warning btn-sm btn-bold <?= ($is_admin) ? '' : 'hide' ?>">
                                <i class="fa fa-cloud-download bigger-120"></i> Sinkron Mahasiswa
                            </button>
                        </div>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-6 no-padding-left no-padding-right">
                        <div id="user-profile-1" class="user-profile row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> NIM </div>
                                        <div class="profile-info-value">
                                            <span class="bolder blue"><?= $detail['nim'] ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Angkatan </div>
                                        <div class="profile-info-value">
                                            <span><?= $detail['angkatan'] ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Program Studi </div>
                                        <div class="profile-info-value">
                                            <span class="bolder"><?= $detail['nama_prodi'] ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Status </div>
                                        <div class="profile-info-value">
                                            <?= st_mhs($detail['status_mhs']) ?>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Jenis Kelamin </div>
                                        <div class="profile-info-value">
                                            <span><?= $detail['kelamin_mhs'] ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Tanggal Lahir </div>
                                        <div class="profile-info-value">
                                            <span><?= format_date($detail['lahir_mhs'],1) ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Agama </div>
                                        <div class="profile-info-value">
                                            <span><?= $detail['agama_mhs'] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Telepon </div>
                                        <div class="profile-info-value">
                                            <span><?= element('telepon_mhs', $akun, '') ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Alamat </div>
                                        <div class="profile-info-value">
                                            <span><?= element('alamat_mhs', $akun, '') ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Catatan </div>
                                        <div class="profile-info-value">
                                            <span><?= $detail['note_mhs'] ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row ">
                                        <div class="profile-info-name">Log :</div>
                                        <div class="profile-info-value">
                                            <span>
                                                <span class="blue"><i class="ace-icon fa fa-user"></i> &nbsp;&nbsp;<?= $detail['log_mhs'] ?></span><br/>
                                                <span class="orange"><i class="ace-icon fa fa-pencil-square-o"></i> &nbsp;&nbsp;<?= selisih_wkt($detail['update_mhs'], 0) ?></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Dosen PA </div>
                                        <div class="profile-info-value">
                                            <span class="bolder"><?= element('nama_dosen', $pa, '') ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> NIDN </div>
                                        <div class="profile-info-value">
                                            <span><?= element('nidn', $pa, '') ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                            </div>
                            <div class="col-xs-12 col-sm-6 <?= ($is_admin) ? '' : 'hide' ?>">
                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name" style="width: 10px"></div>
                                        <div class="profile-info-value">
                                            <p id="span-mhs" style="overflow-y: auto; max-height: 300px"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-18">
                    <li class="<?= ($is_admin) ? '' : 'hide' ?>">
                        <a data-toggle="tab" href="#krs">
                            <i class="blue ace-icon fa fa-check-square-o bigger-120"></i>
                            KRS Mahasiswa
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#nilai">
                            <i class="orange ace-icon fa fa-star-half-o bigger-120"></i>
                            KHS Mahasiswa
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#kuliah">
                            <i class="blue ace-icon fa fa-archive bigger-120"></i>
                            Aktivitas Perkuliahan
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#transfer">
                            <i class="purple ace-icon fa fa-retweet bigger-120"></i>
                            Transfer & PMM
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#merdeka">
                            <i class="pink2 ace-icon fa fa-retweet bigger-120"></i>
                            Kampus Merdeka
                        </a>
                    </li>
                    <li class="<?= ($is_admin) ? '' : 'hide' ?>">
                        <a data-toggle="tab" href="#transkrip">
                            <i class="green ace-icon fa fa-graduation-cap bigger-120"></i>
                            Transkrip
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#bayar">
                            <i class="red ace-icon fa fa-dollar bigger-120"></i>
                            Riwayat Pembayaran
                        </a>
                    </li>
                </ul>
                <div class="tab-content no-border padding-24">
                    <div id="nilai" class="tab-pane">
                        <div class="row">
                            <div class="col-xs-12">
                                <form id="nilai-form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-1 no-padding-right">Semester :</label>
                                        <div class="col-xs-12 col-sm-3">
                                            <div class="clearfix">
                                                <select class="select2 width-100" name="semester" id="semester" data-placeholder="------> Pilih Semester <------">
                                                    <option value=""> </option>
                                                    <?php
                                                    foreach ($semester['data'] as $val) {
                                                        $selected = ($this->session->userdata('idsmt') == $val['id_semester']) ? 'selected' : '';
                                                        echo '<option value="'.encode($val['id_semester']).'" '.$selected.'>'.$val['nama_semester'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <span class="help-inline col-xs-10 col-sm-offset-1">
                                            <small class="middle orange">* Kosongkan untuk melihat semua nilai semester</small>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-12">
                                <div class="widget-box transparent">
                                    <div class="widget-header">
                                        <h5 class="widget-title"><i class="ace-icon fa fa-list-ol"></i> Kartu Hasil Studi</h5>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse" class="orange2">
                                                <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                                            </a>
                                        </div>
                                        <div class="widget-toolbar no-border">
                                            <div class="btn-group btn-overlap">
                                                <button id="btn-nilai" class="btn btn-white btn-primary btn-sm btn-bold">
                                                    <i class="fa fa-search-plus bigger-120"></i> Lihat Data
                                                </button>
                                                <button id="btn-print-khs" class="btn btn-white btn-default btn-sm btn-bold">
                                                    <i class="fa fa-print bigger-120"></i> Cetak Data
                                                </button>
                                                <button id="btn-export-khs" class="btn btn-white btn-success btn-sm btn-bold">
                                                    <i class="fa fa-file-excel-o bigger-120"></i> Transkrip Sementara
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-2 table-responsive">
                                            <table id="nilai-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th colspan="5"></th>
                                                        <th colspan="3">Nilai</th>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Semester</th>
                                                        <th>Kode MK</th>
                                                        <th>Nama MK</th>
                                                        <th>Bobot MK (sks)</th>
                                                        <th>Angka</th>
                                                        <th>Huruf</th>
                                                        <th>Indeks</th>
                                                        <th>sks * N.Indeks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4">Total SKS</th>
                                                        <th id="txt-nsks" class="green bigger-110">0</th>
                                                        <th colspan="3"></th>
                                                        <th id="txt-nindeks" class="grey bigger-110">0</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="8">IPS</th>
                                                        <th id="txt-nipk" class="red bigger-130">0</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="krs" class="tab-pane">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="widget-box transparent">
                                    <div class="widget-header">
                                        <h5 class="widget-title"><i class="ace-icon fa fa-list-ol"></i> Kartu Rencana Studi </h5>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse" class="orange2">
                                                <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                                            </a>
                                        </div>
                                        <div class="widget-toolbar no-border">
                                            <div class="btn-group btn-overlap">
                                                <button id="btn-krs" class="btn btn-white btn-primary btn-sm btn-bold">
                                                    <i class="fa fa-search-plus bigger-120"></i> Lihat Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-2 table-responsive">
                                            <table id="krs-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Semester</th>
                                                        <th>Kode MK</th>
                                                        <th>Nama MK</th>
                                                        <th>Nama Kelas</th>
                                                        <th>Bobot MK (sks)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4">Total SKS</th>
                                                        <th id="txt-ksks" class="green bigger-110">0</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="kuliah" class="tab-pane">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="widget-box transparent">
                                    <div class="widget-header">
                                        <h5 class="widget-title"><i class="ace-icon fa fa-list-ol"></i> Aktivitas Perkuliahan</h5>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse" class="orange2">
                                                <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                                            </a>
                                        </div>
                                        <div class="widget-toolbar no-border">
                                            <div class="btn-group btn-overlap">
                                                <button id="btn-akm" class="btn btn-white btn-primary btn-sm btn-bold">
                                                    <i class="fa fa-search-plus bigger-120"></i> Lihat Data
                                                </button>
                                                <button id="btn-print-akm" class="btn btn-white btn-default btn-sm btn-bold">
                                                    <i class="fa fa-print bigger-120"></i> Cetak Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-2 table-responsive">
                                            <table id="akm-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Semester</th>
                                                        <th>Status</th>
                                                        <th>IPS</th>
                                                        <th>IPK</th>
                                                        <th>SKS Semester</th>
                                                        <th>SKS Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="transkrip" class="tab-pane">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="widget-box transparent">
                                    <div class="widget-header">
                                        <h5 class="widget-title"><i class="ace-icon fa fa-list-ol"></i> Transkrip Akademik</h5>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse" class="orange2">
                                                <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                                            </a>
                                        </div>
                                        <div class="widget-toolbar no-border">
                                            <div class="btn-group btn-overlap">
                                                <button id="btn-transkrip" class="btn btn-white btn-primary btn-sm btn-bold">
                                                    <i class="fa fa-search-plus bigger-120"></i> Lihat Data
                                                </button>
                                                <button id="btn-print-transkrip" class="btn btn-white btn-default btn-sm btn-bold">
                                                    <i class="fa fa-print bigger-120"></i> Cetak Data
                                                </button>
                                                <button id="btn-export-transkrip" class="btn btn-white btn-success btn-sm btn-bold">
                                                    <i class="fa fa-file-excel-o bigger-120"></i> Transkrip Akademik
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-2 table-responsive">
                                            <table id="trans-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4"></th>
                                                        <th colspan="3">Nilai</th>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Kode MK</th>
                                                        <th>Nama MK</th>
                                                        <th>Bobot MK (sks)</th>
                                                        <th>Angka</th>
                                                        <th>Huruf</th>
                                                        <th>Indeks</th>
                                                        <th>sks * N.Indeks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3">Total SKS</th>
                                                        <th id="txt-sks" class="green bigger-110">0</th>
                                                        <th colspan="3"></th>
                                                        <th id="txt-indeks" class="grey bigger-110">0</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="7">IPK</th>
                                                        <th id="txt-ipk" class="red bigger-130">0</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="transfer" class="tab-pane">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="widget-box transparent">
                                    <div class="widget-header">
                                        <h5 class="widget-title"><i class="ace-icon fa fa-list-ol"></i> Nilai Transfer & PMM</h5>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse" class="orange2">
                                                <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                                            </a>
                                        </div>
                                        <div class="widget-toolbar no-border">
                                            <div class="btn-group btn-overlap">
                                                <button id="btn-transfer" class="btn btn-white btn-primary btn-sm btn-bold">
                                                    <i class="fa fa-search-plus bigger-120"></i> Lihat Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-2 table-responsive">
                                            <table id="transfer-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Kode MK Asal</th>
                                                        <th>Nama MK Asal</th>
                                                        <th>Bobot MK Asal</th>
                                                        <th>Nilai Asal</th>
                                                        <th>Kode MK Akui</th>
                                                        <th>Nama MK Akui</th>
                                                        <th>Bobot MK Akui</th>
                                                        <th>Nilai Akui</th>
                                                        <th>Indeks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="7">Total SKS</th>
                                                        <th id="txt-tsks" class="green bigger-110">0</th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="merdeka" class="tab-pane">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="widget-box transparent">
                                    <div class="widget-header">
                                        <h5 class="widget-title"><i class="ace-icon fa fa-list-ol"></i> Konversi Kampus Merdeka</h5>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse" class="orange2">
                                                <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                                            </a>
                                        </div>
                                        <div class="widget-toolbar no-border">
                                            <div class="btn-group btn-overlap">
                                                <button id="btn-merdeka" class="btn btn-white btn-primary btn-sm btn-bold">
                                                    <i class="fa fa-search-plus bigger-120"></i> Lihat Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-2 table-responsive">
                                            <table id="merdeka-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th colspan="5"></th>
                                                        <th colspan="3">Nilai</th>
                                                    </tr>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Semester</th>
                                                        <th>Program</th>
                                                        <th>Nama MK</th>
                                                        <th>Bobot MK (sks)</th>
                                                        <th>Angka</th>
                                                        <th>Huruf</th>
                                                        <th>Indeks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4">Total SKS</th>
                                                        <th id="txt-msks" class="green bigger-110">0</th>
                                                        <th colspan="3"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="bayar" class="tab-pane">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="widget-box transparent">
                                    <div class="widget-header">
                                        <h5 class="widget-title">
                                            <i class="ace-icon fa fa-list-ol"></i>
                                            List Pembayaran
                                        </h5>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse" class="orange2">
                                                <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-2 table-responsive">
                                            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Rincian Biaya</th>
                                                        <th>Status</th>
                                                        <th>Total</th>
                                                        <th>Detail - Total Bayar - Tanggal Bayar - Sumber Dana</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $total_biaya = 0;
                                                    $total_bayar = 0;
                                                    foreach ($biaya as $data) {
                                                        $total_biaya += $data['total_biaya'];
                                                        ?>
                                                        <tr>
                                                            <td><?= $no; ?></td>
                                                            <td>
                                                                <strong><?= ctk($data['nama_rincian']); ?></strong><br/>
                                                                <button itemid="<?=$no?>" id="view-btn" class="tooltip-info btn btn-white btn-info btn-mini btn-bold" 
                                                                    data-rel="tooltip" title="Lihat">
                                                                    <span class=""><i class="ace-icon fa fa-search-plus bigger-110"></i></span>
                                                                </button>
                                                            </td>
                                                            <td><?= st_tagih($data['status_biaya']); ?></td>
                                                            <td class="bolder orange"><?= rupiah($data['total_biaya']); ?></td>
                                                            <td id="dtable<?=$no?>" class="smaller-90 table-responsive hide">
                                                                <table class="table table-bordered">
                                                                    <?php
                                                                    $total_hutang = 0;
                                                                    foreach ($data['bayar'] as $row) {
                                                                        $total_bayar += $row['nominal_bayar'];
                                                                        $total_hutang += $row['nominal_bayar'];
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= ctk($row['nama_bayar']); ?> - 
                                                                                <span class="blue bolder">#<?= ctk($row['kode_bayar']); ?></span>
                                                                            </td>
                                                                            <td class="bolder green"><?= rupiah($row['nominal_bayar']); ?></td>
                                                                            <td><span class=""><i class="fa fa-calendar-plus-o"></i> 
                                                                                    <?= format_date($row['tgl_bayar'], 1); ?></span>
                                                                            </td>
                                                                            <td><?= ctk($row['nama_dana']); ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    $hutang = $data['total_biaya'] - $total_hutang;
                                                                    ?>
                                                                    <tr><th colspan="5" class="red"><?= rupiah($hutang) ?></th></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $no++;
                                                    }
                                                    $total_hutang = $total_biaya - $total_bayar;
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3">Total Tagihan</th>
                                                        <th class="orange bigger-110"><?= rupiah($total_biaya) ?></th>
                                                        <th colspan=""></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3">Total Terbayar</th>
                                                        <th class="green bigger-110"><?= rupiah($total_bayar) ?></th>
                                                        <th colspan=""></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3">Total Piutang</th>
                                                        <th class="red bigger-110"><?= rupiah($total_hutang) ?></th>
                                                        <th colspan=""></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<form name="form">
    <input value="<?= encode($detail['id_mhs']) ?>" id="regid" type="hidden" >
    <input value="<?= encode($detail['nim']) ?>" id="nim" type="hidden" >
</form>
<?php
load_js(array(
    'backend/assets/js/dataTables/jquery.dataTables.js',
    'backend/assets/js/dataTables/jquery.dataTables.bootstrap.js',
    'backend/assets/js/select2.js',
    'backend/assets/js/bootbox.min.js'
));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";
    let krsTable, nilaiTable, akmTable, 
        transTable, transferTable, merdekaTable;

    $(document).ready(function () {
        $(".select2").select2({allowClear: true});
        $(".select2-chosen").addClass("center");
        nilai_table();
        krs_table();
        akm_table();
        trans_table();
        transfer_table();
        merdeka_table();
    });
    $(document.body).on("click", "#view-btn", function(event) {
        let id = $(this).attr("itemid");
        let hide = $("#dtable" + id).hasClass("hide");
        if(hide){
            $("#dtable" + id).removeClass("hide");
        }else{
            $("#dtable" + id).addClass("hide");
        }
    });
    $("#btn-bio").click(function () {
        load_bio();
    });
    $("#btn-krs").click(function () {
        load_krs();
    });
    $("#btn-nilai").click(function () {
        load_nilai();
    });
    $("#btn-akm").click(function () {
        load_akm();
    });
    $("#btn-transkrip").click(function () {
        load_trans();
    });
    $("#btn-transfer").click(function () {
        load_transfer();
    });
    $("#btn-merdeka").click(function () {
        load_merdeka();
    });
    $("#btn-print-khs").click(function () {
        let smt = $("#semester").val();
        if(smt === ""){
            myNotif('Peringatan', 'Pilih semester dahulu', 2);
            return;
        }
        window.open(module + "_do/cetak/" + $("#regid").val() + "/khs/" + smt);
    });
    $("#btn-print-akm").click(function () {
        window.open(module + "_do/cetak/" + $("#regid").val() + "/akm");
    });
    $("#btn-print-transkrip").click(function () {
        window.open(module + "_do/cetak/" + $("#regid").val());
    });
    $("#btn-export-khs").click(function () {
        window.location.replace(module + "_do/export/" + $("#regid").val() + "/khs");
    });
    $("#btn-export-transkrip").click(function () {
        window.location.replace(module + "_do/export/" + $("#regid").val());
    });
</script>
<script type="text/javascript">
    function load_bio() {
        var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i>' +
                ' Mohon tunggu . . . </h4>';
        var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                ' Jangan menutup atau me-refresh halaman ini, silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
        var progress = bootbox.dialog({
            title: title,
            message: msg,
            closeButton: false
        });
        $.ajax({
            url: module + "/ajax/type/table/source/bio",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#regid").val()
            },
            success: function(rs) {
                progress.modal("hide");
                if (rs.status) {
                    show_data(rs.data);
                    myNotif('Informasi', rs.msg, 1);
                } else {
                    $("#span-mhs").html(rs.msg);
                    myNotif('Peringatan', rs.msg, 2);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Error', 'Kesalahan Jaringan', 3);
            }
        });
    }
    function load_krs() {
        var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i>' +
                ' Mohon tunggu . . . </h4>';
        var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                ' Jangan menutup atau me-refresh halaman ini, silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
        var progress = bootbox.dialog({
            title: title,
            message: msg,
            closeButton: false
        });
        $.ajax({
            url: module + "/ajax/type/table/source/krs",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#regid").val()
            },
            success: function (rs) {
                progress.modal("hide");
                krsTable.fnClearTable();
                if (rs.status) {
                    $.each(rs.data.table, function (index, value) {
                        krsTable.fnAddData(value);
                    });
                    $("#txt-ksks").html(rs.data.sks);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                krsTable.fnDraw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Peringatan', 'Tidak dapat memuat data dengan baik', 3);
            }
        });
    }
    function load_nilai() {
        var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i>' +
                ' Mohon tunggu . . . </h4>';
        var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                ' Jangan menutup atau me-refresh halaman ini, silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
        var progress = bootbox.dialog({
            title: title,
            message: msg,
            closeButton: false
        });
        $.ajax({
            url: module + "/ajax/type/table/source/nilai",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#regid").val(),
                smt: $("#semester").val()
            },
            success: function (rs) {
                progress.modal("hide");
                nilaiTable.fnClearTable();
                if (rs.status) {
                    $.each(rs.data.table, function (index, value) {
                        nilaiTable.fnAddData(value);
                    });
                    $("#txt-nsks").html(rs.data.sks);
                    $("#txt-nindeks").html(rs.data.indeks);
                    $("#txt-nipk").html(rs.data.ipk);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                nilaiTable.fnDraw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Peringatan', 'Tidak dapat memuat data dengan baik', 3);
            }
        });
    }
    function load_akm() {
        var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i>' +
                ' Mohon tunggu . . . </h4>';
        var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                ' Jangan menutup atau me-refresh halaman ini, silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
        var progress = bootbox.dialog({
            title: title,
            message: msg,
            closeButton: false
        });
        $.ajax({
            url: module + "/ajax/type/table/source/akm",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#regid").val()
            },
            success: function (rs) {
                progress.modal("hide");
                akmTable.fnClearTable();
                if (rs.status) {
                    $.each(rs.data, function (index, value) {
                        akmTable.fnAddData(value);
                    });
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                akmTable.fnDraw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Peringatan', 'Tidak dapat memuat data dengan baik', 3);
            }
        });
    }
    function load_trans() {
        var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i>' +
                ' Mohon tunggu . . . </h4>';
        var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                ' Jangan menutup atau me-refresh halaman ini, silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
        var progress = bootbox.dialog({
            title: title,
            message: msg,
            closeButton: false
        });
        $.ajax({
            url: module + "/ajax/type/table/source/transkrip",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#regid").val()
            },
            success: function (rs) {
                progress.modal("hide");
                transTable.fnClearTable();
                if (rs.status) {
                    $.each(rs.data.table, function (index, value) {
                        transTable.fnAddData(value);
                    });
                    $("#txt-sks").html(rs.data.sks);
                    $("#txt-indeks").html(rs.data.indeks);
                    $("#txt-ipk").html(rs.data.ipk);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                transTable.fnDraw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Peringatan', 'Tidak dapat memuat data dengan baik', 3);
            }
        });
    }
    function load_transfer() {
        var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i>' +
                ' Mohon tunggu . . . </h4>';
        var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                ' Jangan menutup atau me-refresh halaman ini, silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
        var progress = bootbox.dialog({
            title: title,
            message: msg,
            closeButton: false
        });
        $.ajax({
            url: module + "/ajax/type/table/source/transfer",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#regid").val()
            },
            success: function (rs) {
                progress.modal("hide");
                transferTable.fnClearTable();
                if (rs.status) {
                    $.each(rs.data.table, function (index, value) {
                        transferTable.fnAddData(value);
                    });
                    $("#txt-tsks").html(rs.data.sks);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                transferTable.fnDraw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Peringatan', 'Tidak dapat memuat data dengan baik', 3);
            }
        });
    }
    function load_merdeka() {
        var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i>' +
                ' Mohon tunggu . . . </h4>';
        var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                ' Jangan menutup atau me-refresh halaman ini, silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
        var progress = bootbox.dialog({
            title: title,
            message: msg,
            closeButton: false
        });
        $.ajax({
            url: module + "/ajax/type/table/source/merdeka",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#nim").val()
            },
            success: function (rs) {
                progress.modal("hide");
                merdekaTable.fnClearTable();
                if (rs.status) {
                    $.each(rs.data.table, function (index, value) {
                        merdekaTable.fnAddData(value);
                    });
                    $("#txt-msks").html(rs.data.sks);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                merdekaTable.fnDraw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Peringatan', 'Tidak dapat memuat data dengan baik', 3);
            }
        });
    }
    function show_data(data){
        var str = '';
        $.each(data, function(key, value) {
            str += key + ' : <b>' + value + '</b><br>';
        });
        $("#span-mhs").html(str);
    }
    function nilai_table() {
        nilaiTable = $("#nilai-table")
        .dataTable({
            iDisplayLength: 100,
            bScrollCollapse: true,
            bAutoWidth: false,
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0]},
                {bSearchable: false, aTargets: [0]},
                {sClass: "center", aTargets: [0, 1, 2, 3, 4, 5, 6, 7, 8]},
                {sClass: "center nowrap", aTargets: []}
            ],
            oLanguage: {
                sSearch: "Cari : ",
                sInfoEmpty: "Menampilkan dari 0 sampai 0 dari total 0 data",
                sInfo: "Menampilkan dari _START_ sampai _END_ dari total _TOTAL_ data",
                sLengthMenu: "_MENU_ data per halaman",
                sZeroRecords: "Maaf tidak ada data yang ditemukan",
                sInfoFiltered: "(Menyaring dari _MAX_ total data)"
            }
        });
        nilaiTable.fnAdjustColumnSizing();
    }
    function krs_table() {
        krsTable = $("#krs-table")
        .dataTable({
            iDisplayLength: 100,
            bScrollCollapse: true,
            bAutoWidth: false,
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0]},
                {bSearchable: false, aTargets: [0]},
                {sClass: "center", aTargets: [0, 1, 2, 3, 4, 5]},
                {sClass: "center nowrap", aTargets: []}
            ],
            oLanguage: {
                sSearch: "Cari : ",
                sInfoEmpty: "Menampilkan dari 0 sampai 0 dari total 0 data",
                sInfo: "Menampilkan dari _START_ sampai _END_ dari total _TOTAL_ data",
                sLengthMenu: "_MENU_ data per halaman",
                sZeroRecords: "Maaf tidak ada data yang ditemukan",
                sInfoFiltered: "(Menyaring dari _MAX_ total data)"
            }
        });
        krsTable.fnAdjustColumnSizing();
    }
    function akm_table() {
        akmTable = $("#akm-table")
        .dataTable({
            bScrollCollapse: true,
            bAutoWidth: false,
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0]},
                {bSearchable: false, aTargets: [0]},
                {sClass: "center", aTargets: [0, 1, 2, 3, 4, 5, 6]},
                {sClass: "center nowrap", aTargets: []}
            ],
            oLanguage: {
                sSearch: "Cari : ",
                sInfoEmpty: "Menampilkan dari 0 sampai 0 dari total 0 data",
                sInfo: "Menampilkan dari _START_ sampai _END_ dari total _TOTAL_ data",
                sLengthMenu: "_MENU_ data per halaman",
                sZeroRecords: "Maaf tidak ada data yang ditemukan",
                sInfoFiltered: "(Menyaring dari _MAX_ total data)"
            }
        });
        akmTable.fnAdjustColumnSizing();
    }
    function trans_table() {
        transTable = $("#trans-table")
        .dataTable({
            iDisplayLength: 100,
            bScrollCollapse: true,
            bAutoWidth: false,
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0]},
                {bSearchable: false, aTargets: [0]},
                {sClass: "center", aTargets: [0, 1, 2, 3, 4, 5, 6, 7]},
                {sClass: "center nowrap", aTargets: []}
            ],
            oLanguage: {
                sSearch: "Cari : ",
                sInfoEmpty: "Menampilkan dari 0 sampai 0 dari total 0 data",
                sInfo: "Menampilkan dari _START_ sampai _END_ dari total _TOTAL_ data",
                sLengthMenu: "_MENU_ data per halaman",
                sZeroRecords: "Maaf tidak ada data yang ditemukan",
                sInfoFiltered: "(Menyaring dari _MAX_ total data)"
            }
        });
        transTable.fnAdjustColumnSizing();
    }
    function transfer_table() {
        transferTable = $("#transfer-table")
        .dataTable({
            iDisplayLength: 50,
            bScrollCollapse: true,
            bAutoWidth: false,
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0]},
                {bSearchable: false, aTargets: [0]},
                {sClass: "center", aTargets: [0,1,2,3,4,5,6,7,8,9]},
                {sClass: "center nowrap", aTargets: []}
            ],
            oLanguage: {
                sSearch: "Cari : ",
                sInfoEmpty: "Menampilkan dari 0 sampai 0 dari total 0 data",
                sInfo: "Menampilkan dari _START_ sampai _END_ dari total _TOTAL_ data",
                sLengthMenu: "_MENU_ data per halaman",
                sZeroRecords: "Maaf tidak ada data yang ditemukan",
                sInfoFiltered: "(Menyaring dari _MAX_ total data)"
            }
        });
        transferTable.fnAdjustColumnSizing();
    }
    function merdeka_table() {
        merdekaTable = $("#merdeka-table")
        .dataTable({
            iDisplayLength: 100,
            bScrollCollapse: true,
            bAutoWidth: false,
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0]},
                {bSearchable: false, aTargets: [0]},
                {sClass: "center", aTargets: [0, 1, 2, 3, 4, 5, 6, 7]},
                {sClass: "center nowrap", aTargets: []}
            ],
            oLanguage: {
                sSearch: "Cari : ",
                sInfoEmpty: "Menampilkan dari 0 sampai 0 dari total 0 data",
                sInfo: "Menampilkan dari _START_ sampai _END_ dari total _TOTAL_ data",
                sLengthMenu: "_MENU_ data per halaman",
                sZeroRecords: "Maaf tidak ada data yang ditemukan",
                sInfoFiltered: "(Menyaring dari _MAX_ total data)"
            }
        });
        merdekaTable.fnAdjustColumnSizing();
    }
</script>