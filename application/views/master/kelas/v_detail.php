<?php $this->load->view('sistem/v_breadcrumb'); ?>
<style>
    .profile-info-name{
        width: 160px;
    }
    .select2-container{
        padding-left: 0px;
    }
    .select2-chosen{
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
            <div id="user-profile-1" class="user-profile row">
                <div class="col-xs-12 col-sm-6">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Semester </div>
                            <div class="profile-info-value">
                                <span><?= is_periode($detail['id_semester'],1) ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Program Studi </div>
                            <div class="profile-info-value">
                                <span><?= $prodi['nama_prodi'] ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Kode MK </div>
                            <div class="profile-info-value">
                                <span class="bolder"><?= $detail['kode_matkul'] ?></span>
                                <small>[<?= $detail['jenis_matkul'] ?>]</small>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Nama MK </div>
                            <div class="profile-info-value">
                                <span class="bolder blue"><?= $detail['nama_matkul'] ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Semester </div>
                            <div class="profile-info-value">
                                <span class="bolder bigger-120"><?= $detail['semester_kelas'] ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Nama Kelas </div>
                            <div class="profile-info-value">
                                <span class="bolder bigger-120"><?= $detail['nama_kelas'] ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Bobot MK</div>
                            <div class="profile-info-value">
                                <span class="bolder red bigger-130"><?= $detail['sks_matkul'] ?></span> sks
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Status </div>
                            <div class="profile-info-value">
                                <?= st_aktif($detail['status_kelas']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="space-4"></div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Dosen Pengampu </div>
                            <div class="profile-info-value">
                                <span class="bolder"><?= $detail['nama_dosen'] ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Peserta Kelas </div>
                            <div class="profile-info-value">
                                <span id="txt-peserta" class="bolder"><?= $detail['jumlah_mhs'] ?></span> Mahasiswa
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Jadwal Kelas </div>
                            <div class="profile-info-value">
                                <span><?= $detail['jadwal_kelas'] ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row ">
                            <div class="profile-info-name">Log :</div>
                            <div class="profile-info-value">
                                <span>
                                    <span class="blue"><i class="ace-icon fa fa-user"></i> &nbsp;&nbsp;<?= $detail['log_kelas'] ?></span><br/>
                                    <span class="orange"><i class="ace-icon fa fa-pencil-square-o"></i> &nbsp;&nbsp;<?= selisih_wkt($detail['update_kelas'], 0) ?></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="space-4"></div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Kelas </div>
                            <div class="profile-info-value">
                                <input name="kelas" id="kelas" type="hidden" placeholder="Masukkan Kode/Nama MK" class="width-100">
                                <span class="help-inline">
                                    <span class="middle blue bolder" id="txt-kelas"></span>
                                </span>
                                <div class="space-4"></div>
                                <button class="btn btn-primary btn-white btn-bold btn-sm" id="btn-pindah-all" type="button">
                                    <i class="fa fa-exchange bigger-120"></i> Pindah Kelas
                                </button>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">  </div>
                            <div class="profile-info-value">
                                <button class="<?= empty($detail['id_dosen']) ? 'hide':'' ?> btn btn-danger btn-white btn-bold btn-sm" id="btn-delete-dosen" type="button">
                                    <i class="fa fa-trash bigger-120"></i> Hapus Dosen Pengampu
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="space-4"></div>
                </div>
            </div>
        </div><!-- /.col -->
        <div class="col-sm-6 col-xs-12">
            <div class="widget-box widget-color-grey">
                <div class="widget-header">
                    <h5 class="widget-title">
                        <i class="ace-icon fa fa-list-ol"></i>
                        Data Lokal
                    </h5>
                    <div class="widget-toolbar">
                        <a href="#" id="span-log" data-action="settings">
                            <i class="ace-icon fa fa-expand bigger-125"></i>
                        </a>
                        <a href="#" data-action="collapse" class="">
                            <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                        </a>
                    </div>
                    <div class="widget-toolbar no-border">
                        <div class="btn-group btn-overlap">
                            <button id="btn-krs-all" class="btn btn-white btn-success btn-sm btn-bold">
                                <i class="fa fa-user-plus bigger-120"></i> Input KRS
                            </button>
                            <button id="btn-khs-all" class="btn btn-white btn-warning btn-sm btn-bold">
                                <i class="fa fa-check-square-o bigger-120"></i> Input KHS
                            </button>
                        </div>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-2 table-responsive">
                        <table id="lokal-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace"/>
                                            <span class="lbl"></span>
                                        </label>
                                    </th>
                                    <th>Mahasiswa</th>
                                    <th width="15%">Nilai</th>
                                    <th width="17%">KRS & KHS</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="widget-box widget-color-green2">
                <div class="widget-header">
                    <h5 class="widget-title">
                        <i class="ace-icon fa fa-cloud-download bigger-120"></i>
                        Data PDDikti
                    </h5>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse" class="">
                            <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                        </a>
                    </div>
                    <div class="widget-toolbar no-border">
                        <div class="btn-group btn-overlap">
                            <button id="btn-feeder" class="btn btn-white btn-primary btn-sm btn-bold">
                                <i class="fa fa-retweet bigger-120"></i> Sinkron Peserta
                            </button>
                            <button id="btn-delete-all" class="btn btn-white btn-danger btn-sm btn-bold">
                                <i class="fa fa-trash bigger-120"></i> Hapus Peserta
                            </button>
                        </div>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-2 table-responsive">
                        <table id="feeder-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace"/>
                                            <span class="lbl"></span>
                                        </label>
                                    </th>
                                    <th>Mahasiswa</th>
                                    <th>Nilai</th>
                                    <th>KRS</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 <?= empty($detail['id_dosen']) ? '':'hide' ?>">
            <div class="widget-box transparent">
                <div class="widget-header">
                    <h5 class="widget-title">
                        <i class="ace-icon fa fa-pencil"></i>
                        Tambah Dosen Pengajar
                    </h5>
                    <div class="widget-toolbar no-border">
                        <a href="#" data-action="collapse" class="">
                            <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-20">
                        <form id="dosen-form" name="dosen-form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                            <input value="<?= encode($detail['id_kelas']) ?>" type="hidden" name="kelas">
                            <input value="<?= $detail['sks_matkul'] ?>" type="hidden" name="substansi">
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-4 no-padding-right">Praktisi :</label>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="clearfix">
                                        <label class="control-label">
                                            <input name="tipe" value="0" type="radio" class="ace" />
                                            <span class="lbl"> YA </span>
                                        </label>&nbsp;&nbsp;&nbsp;
                                        <label class="control-label">
                                            <input name="tipe" value="1" type="radio" class="ace" />
                                            <span class="lbl"> TIDAK </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-4 no-padding-right">Dosen Pengampu :</label>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="clearfix">
                                        <input type="hidden" name="dosen" id="dosen" placeholder="------> Pilih Pilih Dosen <------" class="width-100"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-4 no-padding-right">Rencana :</label>
                                <div class="col-xs-12 col-sm-3">
                                    <div class="clearfix">
                                        <input value="16" type="number" name="rencana" id="rencana" class="col-xs-12  col-sm-6" placeholder="? Minggu" />
                                        &nbsp;&nbsp;Pertemuan
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-4 no-padding-right">Realisasi :</label>
                                <div class="col-xs-12 col-sm-3">
                                    <div class="clearfix">
                                        <input value="16" type="number" name="realisasi" id="realisasi" class="col-xs-12  col-sm-6" placeholder="? Minggu" />
                                        &nbsp;&nbsp;Pertemuan
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-4 no-padding-right">Jenis Evaluasi :</label>
                                <div class="col-xs-12 col-sm-3">
                                    <div class="clearfix">
                                        <select class="select2 width-100" name="jenis" id="jenis" data-placeholder="---> Pilih Jenis <---">
                                            <option value=""> </option>
                                            <?php
                                            foreach ($jenis_evaluasi as $val) {
                                                $selected = (1 == $val['id']) ? 'selected' : '';
                                                echo '<option value="' . $val['id'] . '" '.$selected.'>' . $val['txt'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-sm-offset-4 col-sm-6">
                                    <button class="btn" type="reset">
                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                        Batal
                                    </button>
                                    &nbsp; &nbsp; &nbsp;
                                    <button class="btn btn-success" name="simpan" id="simpan" type="submit">
                                        <i class="ace-icon fa fa-check"></i>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<form>
    <input value="<?= encode($detail['id_kelas']) ?>" type="hidden" name="id" id="id">
</form>
<?php
load_js(array(
    'backend/assets/js/dataTables/jquery.dataTables.js',
    'backend/assets/js/dataTables/jquery.dataTables.bootstrap.js',
    'backend/assets/js/select2.js',
    'backend/assets/js/bootbox.min.js',
    'backend/assets/js/jquery.validate.js'
));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";  
    const module_do = module + "_do";  
    let feederTable, lokalTable;
    
    $(function () {
        $(".select2").select2({allowClear: true});
        $(".select2-chosen").addClass("center");
        
        get_select();
        //load_lokal();
        feeder_table();
        lokal_table();
    });
</script>
<script type="text/javascript">
    $("#kelas").change(function () {
        let data = $("#kelas").select2('data');
        $("#txt-kelas").html(data.text);
    });
    $("input[name='tipe']").change(function () {
        $("#dosen").select2('val','');
    });
    $("#btn-feeder").click(function () {
        load_feeder();
        load_lokal();
    });
    $("#span-log").click(function () {
        if($(".sp-log").hasClass("hide")){
            $(".sp-log").removeClass("hide"); 
        }else{
            $(".sp-log").addClass("hide");
        }
    });
    $("#feeder-table > thead > tr > th input[type=checkbox]").eq(0).on('click', function(){
        var $row = $("#feeder-table > tbody > tr > td:first-child input[type='checkbox']");
        if(!this.checked){
            $row.prop('checked', false).closest('tr').removeClass('danger');  
        } else {
            $row.prop('checked', true).closest('tr').addClass('danger');
        }
    });
    $("#lokal-table > thead > tr > th input[type=checkbox]").eq(0).on('click', function(){
        var $row = $("#lokal-table > tbody > tr > td:first-child input[type='checkbox']");
        if(!this.checked){
            $row.prop('checked', false).closest('tr').removeClass('danger');
        } else {
            $row.prop('checked', true).closest('tr').addClass('danger');
        }
    });
    $("#feeder-table").on('click', 'td input[type=checkbox]' , function(){
        var $row = $(this).closest('tr');
        if(this.checked) $row.addClass('danger');
        else $row.removeClass('danger');
    });
    $("#lokal-table").on('click', 'td input[type=checkbox]' , function(){
        var $row = $(this).closest('tr');
        if(this.checked) $row.addClass('danger');
        else $row.removeClass('danger');
    });
    $("#btn-delete-all").click(function(e) {
        var rowcollection = feederTable.$("#regid:checked", {"page": "all"});
        var id = "";
        var qty = 0;
        rowcollection.each(function(index, elem) {
            var checkbox_value = $(elem).val();
            id += checkbox_value + ',';
            qty++;
        });
        if(id === ""){
            myNotif('Peringatan', 'Tidak ada data yang terpilih', 2);
            return;
        }
        var title = "<h4 class='red center'><i class='ace-icon fa fa-exclamation-triangle red'></i>" + 
                " Peringatan !</h4>";
        var msg = "<p class='center grey bigger-120'><i class='ace-icon fa fa-hand-o-right blue'></i>" +
                "<strong class='bigger-130 red'> " + qty + "</strong><br/>Data yang anda pilih akan di <b>Hapus dari Feeder PDDikti</b>. " + 
                "<br/>Harap diperhatikan dengan baik!</p>";
        bootbox.confirm({
            title: title,
            message: msg, 
            buttons: {
                cancel: {
                    label: "<i class='ace-icon fa fa-times bigger-110'></i> Batal",
                    className: "btn btn-sm"
                },
                confirm: {
                    label: "<i class='ace-icon fa fa-trash bigger-110'></i> Hapus",
                    className: "btn btn-sm btn-danger"
                }
            },
            callback: function(result) {
                if (result === true) {
                    delete_feeder(id);
                }
            }
        });
    });
    $("#btn-krs-all").click(function(e) {
        var rowcollection = lokalTable.$("#mid:checked", {"page": "all"});
        var id = "";
        var qty = 0;
        rowcollection.each(function(index, elem) {
            var checkbox_value = $(elem).val();
            id += checkbox_value + ',';
            qty++;
        });
        if(id === ""){
            myNotif('Peringatan', 'Tidak ada data yang terpilih', 2);
            return;
        }
        var title = "<h4 class='red center'><i class='ace-icon fa fa-exclamation-triangle red'></i>" + 
                " Peringatan !</h4>";
        var msg = "<p class='center grey bigger-120'><i class='ace-icon fa fa-hand-o-right blue'></i>" + 
                "<strong class='bigger-130 red'> " + qty + "</strong><br/> Data yang anda pilih akan di Sinkron kedalam<br/> <b>KRS Mahasiswa Feeder PDDikti</b>. " + 
                "<br/>Harap diperhatikan dengan baik!</p>";
        bootbox.confirm({
            title: title,
            message: msg, 
            buttons: {
                cancel: {
                    label: "<i class='ace-icon fa fa-times bigger-110'></i> Batal",
                    className: "btn btn-sm"
                },
                confirm: {
                    label: "<i class='ace-icon fa fa-paper-plane bigger-110'></i> Kirim",
                    className: "btn btn-sm btn-primary"
                }
            },
            callback: function(result) {
                if (result === true) {
                    sinkron_feeder(id);
                }
            }
        });
    });
    $("#btn-khs-all").click(function(e) {
        var rowcollection = lokalTable.$("#mid:checked", {"page": "all"});
        var id = "";
        var qty = 0;
        rowcollection.each(function(index, elem) {
            var checkbox_value = $(elem).val();
            id += checkbox_value + ',';
            qty++; 
        });
        if(id === ""){
            myNotif('Peringatan', 'Tidak ada data yang terpilih', 2);
            return;
        }
        var title = "<h4 class='red center'><i class='ace-icon fa fa-exclamation-triangle red'></i>" + 
                " Peringatan !</h4>";
        var msg = "<p class='center grey bigger-120'><i class='ace-icon fa fa-hand-o-right blue'></i>" + 
                "<strong class='bigger-130 red'> " + qty + "</strong><br/> Data yang anda pilih akan di Sinkron kedalam<br/> <b>Nilai Perkuliahan Mahasiswa Feeder PDDikti</b>. " + 
                "<br/>Harap diperhatikan dengan baik!</p>";
        bootbox.confirm({
            title: title,
            message: msg, 
            buttons: {
                cancel: {
                    label: "<i class='ace-icon fa fa-times bigger-110'></i> Batal",
                    className: "btn btn-sm"
                },
                confirm: {
                    label: "<i class='ace-icon fa fa-paper-plane bigger-110'></i> Kirim",
                    className: "btn btn-sm btn-primary"
                }
            },
            callback: function(result) {
                if (result === true) {
                    sinkron_feeder(id,'khs');
                }
            }
        });
    });
    $("#btn-pindah-all").click(function(e) {
        var rowcollection = lokalTable.$("#mid:checked", {"page": "all"});
        var id = "";
        var qty = 0;
        rowcollection.each(function(index, elem) {
            var checkbox_value = $(elem).val();
            id += checkbox_value + ',';
            qty++; 
        });
        var kelas = $("#kelas").val();
        if(kelas === ""){
            $("#kelas").select2('open');
            myNotif('Peringatan', 'Pilih Kelas tujuan pemindahan', 2);
            return;
        }
        if(id === ""){
            myNotif('Peringatan', 'Tidak ada data yang terpilih', 2);
            return;
        }
        var title = "<h4 class='red center'><i class='ace-icon fa fa-exclamation-triangle red'></i>" + 
                " Peringatan !</h4>";
        var msg = "<p class='center grey bigger-120'><i class='ace-icon fa fa-hand-o-right blue'></i>" + 
                "<strong class='bigger-130 red'> " + qty + "</strong><br/> Data yang anda pilih akan di Pindahkan kedalam kelas baru <br/> <b>"+$("#txt-kelas").text()+"</b>. " + 
                "<br/>Harap diperhatikan dengan baik!</p>";
        bootbox.confirm({
            title: title,
            message: msg, 
            buttons: {
                cancel: {
                    label: "<i class='ace-icon fa fa-times bigger-110'></i> Batal",
                    className: "btn btn-sm"
                },
                confirm: {
                    label: "<i class='ace-icon fa fa-paper-plane bigger-110'></i> Kirim",
                    className: "btn btn-sm btn-primary"
                }
            },
            callback: function(result) {
                if (result === true) {
                    change_kelas(id,kelas);
                }
            }
        });
    });
    $("#btn-delete-dosen").click(function(e) {
        var title = "<h4 class='red center'><i class='ace-icon fa fa-exclamation-triangle red'></i>" + 
                " Peringatan !</h4>";
        var msg = "<p class='center grey bigger-120'><i class='ace-icon fa fa-hand-o-right blue'></i>" +
                " Dosen Pengampu akan di <b>Hapus dari Feeder PDDikti</b>. " + 
                "<br/>Harap diperhatikan dengan baik!</p>";
        bootbox.confirm({
            title: title,
            message: msg, 
            buttons: {
                cancel: {
                    label: "<i class='ace-icon fa fa-times bigger-110'></i> Batal",
                    className: "btn btn-sm"
                },
                confirm: {
                    label: "<i class='ace-icon fa fa-trash bigger-110'></i> Hapus",
                    className: "btn btn-sm btn-danger"
                }
            },
            callback: function(result) {
                if (result === true) {
                    delete_dosen();
                }
            }
        });
    });
    $("#dosen-form").submit(function (e) {
        if($("#dosen-form").validate().checkForm()){
            add_dosen();
        }
        e.preventDefault();
    });
</script>
<script type="text/javascript">
    function change_kelas(id,kelas) {
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
            url: module_do + "/ajax/type/action/source/change",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#id").val(),
                mhs: id,
                kelas: kelas
            },
            success: function (rs) {
                progress.modal("hide");
                if(rs.status){
                    myNotif('Informasi', rs.msg, 1);
                }else{
                    myNotif('Peringatan', rs.msg, 2);
                }
                $("#kelas").select2('val','');
                $("#txt-kelas").html('');
                feederTable.fnClearTable();
                lokalTable.fnClearTable();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Peringatan', 'Tidak dapat memuat data dengan baik', 3);
            }
        });
    }
    function sinkron_feeder(id, mode = null) {
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
            url: module_do + "/ajax/type/action/source/sinkron",
            dataType: "json",
            type: "POST",
            data: {
                id: $("#id").val(),
                mhs: id,
                mode: mode
            },
            success: function (rs) {
                progress.modal("hide");
                if (rs.status) {
                    myNotif('Informasi', rs.msg, 1);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                feederTable.fnClearTable();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Error', 'Kesalahan jaringan. Mohon ulangi proses', 3); 
            }
        });
    }
    function delete_feeder(id) {
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
            url: module_do + "/ajax/type/action/source/delete",
            dataType: "json",
            type: "POST",
            data: {
                id: $("#id").val(),
                mhs: id
            },
            success: function (rs) {
                progress.modal("hide");
                if (rs.status) {
                    myNotif('Informasi', rs.msg, 1);
                } else {
                    myNotif('Peringatan', rs.msg, 3);
                }
                load_lokal();
                feederTable.fnClearTable();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Error', 'Kesalahan jaringan. Mohon ulangi proses', 3); 
            }
        });
    }
    function add_dosen(){
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
            url: module_do + "/ajax/type/action/source/add_dosen",
            dataType: "json",
            type: "POST",
            data: $("#dosen-form").serialize(),
            success: function (rs) {
                progress.modal("hide");
                if (rs.status) {
                    myNotif('Informasi', rs.msg, 1);
                    setTimeout(function () {
                        window.location.replace(module + '/add');
                    },1000);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Error', 'Kesalahan jaringan. Mohon ulangi proses', 3);
            }
        });
    }
    function delete_dosen(){
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
            url: module_do + "/ajax/type/action/source/delete_dosen",
            dataType: "json",
            type: "POST",
            data: {
                id: $("#id").val()
            },
            success: function (rs) {
                progress.modal("hide");
                if (rs.status) {
                    myNotif('Informasi', rs.msg, 1);
                    setTimeout(function () {
                        location.reload();
                    },1000);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Error', 'Kesalahan jaringan. Mohon ulangi proses', 3);
            }
        });
    }
    function load_feeder() {
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
            url: module + "/ajax/type/table/source/feeder",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#id").val()
            },
            success: function (rs) {
                progress.modal("hide");
                feederTable.fnClearTable();
                if (rs.status) {
                    $.each(rs.data, function (index, value) {
                        feederTable.fnAddData(value);
                    });
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                feederTable.fnDraw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Peringatan', 'Tidak dapat memuat data dengan baik', 3);
            }
        });
    }
    function load_lokal() {
        $.ajax({
            url: module + "/ajax/type/table/source/lokal",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#id").val()
            },
            success: function (rs) {
                lokalTable.fnClearTable();
                if (rs.status) {
                    $.each(rs.data, function (index, value) {
                        lokalTable.fnAddData(value);
                    });
                    $("#txt-peserta").html(rs.data.length);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                lokalTable.fnDraw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                myNotif('Peringatan', 'Tidak dapat memuat data dengan baik', 3);
            }
        });
    }
    function get_select() {
        $("#kelas").select2({
            placeholder: "------> Pilih Kode/Nama MK <------",
            allowClear: true,
            minimumInputLength: 3,
            ajax: { 
                url: module + "/ajax/type/list/source/kelas",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function (term, page) {
                    return { term:term };
                },
                results: function (data, page) {
                    return { results: data };
                },
                cache: true
            }
        });
        $("#dosen").select2({
            placeholder: "------> Pilih Dosen <------",
            allowClear: true,
            //minimumInputLength: 3,
            ajax: { 
                url: module + "/ajax/type/list/source/dosen",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function (term, page) {
                    return { 
                        term: term, tipe: $("input[name='tipe']:checked").val()
                    };
                },
                results: function (data, page) {
                    return { results: data };
                },
                cache: true
            }
        });
    }
    function feeder_table() {
        feederTable = $("#feeder-table")
        .dataTable({
            iDisplayLength: 50,
            bScrollCollapse: true,
            bAutoWidth: false,
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0,3]},
                {bSearchable: false, aTargets: [0,3]},
                {sClass: "center", aTargets: [0, 1, 2]},
                {sClass: "center nowrap", aTargets: [3]}
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
        feederTable.fnAdjustColumnSizing();
    }
    function lokal_table() {
        lokalTable = $("#lokal-table")
        .dataTable({
            iDisplayLength: 50,
            bScrollCollapse: true,
            bAutoWidth: false,
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0,3]},
                {bSearchable: false, aTargets: [0,3]},
                {sClass: "center", aTargets: [0, 1, 2]},
                {sClass: "center nowrap", aTargets: [3]}
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
        lokalTable.fnAdjustColumnSizing();
    }
    $("#dosen-form").validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            tipe: {
                required: true
            },
            dosen: {
                required: true
            },
            rencana: {
                required: true,
                digits: true,
                min: 10,
                max: 16
            },
            realisasi: {
                required: true,
                digits: true,
                min: 10,
                max: 16
            },
            jenis: {
                required: true
            }
        },
        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error').addClass('has-success');
            $(e).remove();
        },
        errorPlacement: function (error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if (controls.find(':checkbox,:radio').length > 1)
                    controls.append(error);
                else
                    error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            } else if (element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            } else if (element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            } else
                error.insertAfter(element.parent());
        },
        invalidHandler: function (form) {
        }
    });
</script>