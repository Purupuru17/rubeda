<?php $this->load->view('sistem/v_breadcrumb'); ?>
<style>
    .profile-info-name{
        width: 160px;
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
            <h4 class="blue">
                <span class="middle bolder"><?= $detail['nama_mhs'] ?></span>
            </h4>
            <div id="user-profile-1" class="user-profile row">
                <div class="col-xs-12 col-sm-6">
                <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> NIM </div>
                            <div class="profile-info-value">
                                <span class="bolder"><?= $detail['nim'] ?></span>
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
                            <div class="profile-info-name"> </div>
                            <div class="profile-info-value">
                                <input value="<?= encode($detail['id_mhs']) ?>" type="hidden" name="mid" id="mid">
                                <button id="btn-akun" class="btn btn-block btn-bold btn-danger btn-white">
                                    <i class="ace-icon fa fa-plus-square bigger-110"></i>
                                    <span class="">Buat Akun/Reset Password</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="space-4"></div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name" style="width: 10px"></div>
                            <div class="profile-info-value">
                                <p id="span-txt"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
        <!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<?php
load_js(array(
    "backend/assets/js/jquery.validate.js",
    "backend/assets/js/bootbox.min.js",
));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";    
    const module_do = module + "_do"; 
    
    $(document).ready(function () {
        load_tmp();
    });
    $("#btn-akun").click(function () {
        var title = "<h4 class='red center'><i class='ace-icon fa fa-exclamation-triangle red'></i>" + 
                " Peringatan !</h4>";
        var msg = "<p class='center grey bigger-120'><i class='ace-icon fa fa-hand-o-right blue'></i>" + 
                " Apabila Akun sudah pernah dibuat sebelumnya, " +
                    "<br/>maka ini akan <b>me-RESET Password</b> akun tersebut. <br/>Harap diperhatikan dengan baik!</p>";
        bootbox.confirm({
            title: title,
            message: msg, 
            buttons: {
                cancel: {
                    label: "<i class='ace-icon fa fa-times bigger-110'></i> Batal",
                    className: "btn btn-sm btn-bold"
                },
                confirm: {
                    label: "<i class='ace-icon fa fa-check bigger-110'></i> Simpan",
                    className: "btn btn-sm btn-success"
                }
            },
            callback: function(result) {
                if (result === true) {
                    config_tmp();
                }
            }
        });
    });
</script>
<script type="text/javascript">
    function config_tmp() {
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
            url: module_do + "/ajax/type/action/source/tmp",
            dataType: "json",
            type: "POST",
            data: {
                id: $("#mid").val()
            },
            success: function (rs) {
                progress.modal("hide");
                if (rs.status) {
                    myNotif('Informasi', rs.msg, 1);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                load_tmp();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Error', 'Kesalahan jaringan. Mohon ulangi proses', 3); 
            }
        });
    }
    function load_tmp() {
        $.ajax({
            url: module + "/ajax/type/table/source/tmp",
            type: "POST",
            dataType: "json",
            data: {
                id: $("#mid").val()
            },
            success: function(rs) {
                if (rs.status) {
                    show_data(rs.data);
                    //myNotif('Informasi', rs.msg, 1);
                } else {
                    $("#span-txt").html(rs.msg);
                    myNotif('Peringatan', rs.msg, 2);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                myNotif('Error', 'Kesalahan Jaringan', 3);
            }
        });
    }
    function show_data(data){
        var str = '';
        $.each(data, function(key, value) {
            str += key + ' : <b>' + value + '</b><br>';
        });
        $("#span-txt").html(str);
    }
</script>
