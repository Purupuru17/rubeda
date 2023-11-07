<?php $this->load->view('sistem/v_breadcrumb'); ?>
<style>
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
            <h3 class="lighter center block blue"><?= $title[1] ?></h3>
            <form id="validation-form" action="<?= site_url($action); ?>" name="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Topik :</label>
                    <div class="col-xs-12 col-sm-3">
                        <div class="clearfix">
                            <select class="select2 width-100" name="topik" id="topik" data-placeholder="------> Pilih Topik <------">
                                <option value=""> </option>
                                <?php
                                foreach ($topik as $val) {
                                    $selected = ($edit['topik_id'] == $val['id_topik']) ? 'selected' : '';
                                    echo '<option value="'.encode($val['id_topik']).'" '.$selected.'>' . $val['judul_topik'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Judul :</label>
                    <div class="col-xs-12 col-sm-7">
                        <div class="clearfix">
                            <input <?= ($this->session->userdata('groupid') != '1' ? 'readonly':'') ?> value="<?= $edit['judul_video'] ?>" type="text" name="judul" id="judul" placeholder="Judul Video" class="col-xs-12  col-sm-6"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Batasan Usia :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="usia" id="usia" data-placeholder="---> Pilih Usia <---">
                                <option value=""> </option>
                                 <?php
                                foreach (load_array('st_usia') as $val) {
                                    $selected = ($edit['usia_video'] == $val['id']) ? 'selected' : '';
                                    echo '<option value="'.$val['id'].'" '.$selected.'>'.$val['txt'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Pengaturan Privasi :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="privasi" id="privasi" data-placeholder="---> Pilih Privasi <---">
                                <option value=""> </option>
                                 <?php
                                foreach (load_array('st_privasi') as $val) {
                                    $selected = ($edit['privasi_video'] == $val['id']) ? 'selected' : '';
                                    echo '<option value="'.$val['id'].'" '.$selected.'>'.$val['txt'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group <?= ($this->session->userdata('groupid') != '1' ? 'hide':'') ?>">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Status :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="status" id="status" data-placeholder="---> Pilih Status <---">
                                <option value=""> </option>
                                 <?php
                                foreach (load_array('st_opsi') as $val) {
                                    $selected = ($edit['status_video'] == $val['id']) ? 'selected' : '';
                                    echo '<option value="'.$val['id'].'" '.$selected.'>'.$val['txt'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Tag :</label>
                    <div class="col-xs-12 col-sm-5">
                        <div class="clearfix">
                            <input value="<?= $edit['tag_video'] ?>" type="text" name="tag" id="tag" placeholder="Tag Video" class="col-xs-12  col-sm-6"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Deskripsi :</label>
                    <div class="col-xs-12 col-sm-6">
                        <div class="clearfix">
                            <textarea cols="1" rows="10" name="deskripsi" id="deskripsi" placeholder="Deskripsi Video" class="col-xs-12"><?= $edit['deskripsi_video'] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Terakhir diubah :</label>
                    <div class="col-xs-12 col-sm-5">
                        <div class="well">
                            <span class="bigger-110 blue"><i class="ace-icon fa fa-user"></i> &nbsp;&nbsp;<?= $edit['log_video'] ?></span><br/>
                            <span class="bigger-110 green"><i class="ace-icon fa fa-pencil"></i> &nbsp;&nbsp;<?= format_date($edit['create_video'],0) ?></span><br/>
                            <span class="bigger-110 orange"><i class="ace-icon fa fa-clock-o"></i> &nbsp;&nbsp;<?= format_date($edit['update_video'],0) ?></span>
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
        <!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<?php
load_js(array(
    'backend/assets/js/select2.js',
    'backend/assets/js/jquery.validate.js',
));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";
    const form = $("#validation-form");
    $(document).ready(function () {
        $(".select2").select2({allowClear: true});
    });
    form.submit(function(){
        if(form.validate().checkForm()){
            var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i> Menyimpan Data . . . </h4>';
            var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                ' Mohon menunggu, jangan menutup atau me-refresh halaman ini. <br>Silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
            bootbox.dialog({
                title: title, message: msg, closeButton: false
            });
        }
    });
    form.validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            topik: {
                required: true
            },
            judul: {
                required: true,
                minlength: 5
            },
            deskripsi: {
                required: true,
                minlength: 30
            },
            usia: {
                required: true
            },
            privasi: {
                required: true
            },
            status: {
                required: true
            },
            tag: {
                required: true,
                minlength: 5
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
