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
                <div class="form-group <?= empty($edit['id_kelas']) ? '' : 'hide' ?>">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Program Studi :</label>
                    <div class="col-xs-12 col-sm-4">
                        <div class="clearfix">
                            <select class="select2 width-100" name="prodi" id="prodi" data-placeholder="------> Pilih Program Studi <------">
                                <option value=""> </option>
                                <?php
                                foreach ($prodi['data'] as $val) {
                                    $selected = ($edit['prodi_id'] == $val['id_prodi']) ? 'selected' : '';
                                    echo '<option value="'.encode($val['id_prodi']).'" '.$selected.'>' . $val['nama_prodi'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Mata Kuliah :</label>
                    <div class="col-xs-12 col-sm-4">
                        <div class="clearfix">
                            <input value="<?= encode($edit['id_matkul']) ?>" type="hidden" name="matkul" id="matkul" placeholder="------> Pilih Mata Kuliah <------" class="width-100"/>
                        </div>
                    </div>
                    <span class="help-inline col-xs-6 col-md-offset-4">
                        <span class="middle blue bolder" id="txt-matkul"></span>
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Bobot SKS :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <input value="<?= $edit['sks_matkul'] ?>" type="number" name="sks" id="sks" placeholder="? sks" class="col-xs-12  col-sm-6"/>
                        </div>
                    </div>
                    <span class="help-inline col-xs-6 col-md-offset-4">
                        <small class="middle blue"><i>sks tatap muka + sks praktik + sks lainnya</i></small>
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Semester :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="semester" id="semester" data-placeholder="--> Pilih Semester <--">
                                <option value=""> </option>
                                <?php
                                $array = str_split($edit['nama_kelas'], 1);
                                foreach (array(1,2,3,4,5,6,7,8) as $val) {
                                    $selected = ($edit['semester_kelas'] == $val && element(0, $array) == $val) ? 'selected' : '';
                                    echo '<option value="' . $val . '" '.$selected.'>' . $val . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Nama Kelas :</label>
                    <div class="col-xs-12 col-sm-3">
                        <div class="clearfix">
                            <input value="<?= element(1, $array) ?>" type="text" name="nama" id="nama" placeholder="A/B/C/D/E dst" class="col-xs-12  col-sm-6"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Lingkup :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="lingkup" id="lingkup" data-placeholder="---> Pilih Lingkup <---">
                                <option value=""> </option>
                                <?php
                                foreach ($lingkup as $val) {
                                    $selected = (1 == $val['id']) ? 'selected' : '';
                                    echo '<option value="' . $val['id'] . '" '.$selected.'>' . $val['txt'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Mode :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="mode" id="mode" data-placeholder="---> Pilih Mode <---">
                                <option value=""> </option>
                                <?php
                                foreach ($mode as $val) {
                                    $selected = ('F' == $val['id']) ? 'selected' : '';
                                    echo '<option value="' . $val['id'] . '" '.$selected.'>' . $val['txt'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Tanggal Mulai :</label>
                    <div class="col-xs-12 col-sm-3">
                        <div class="clearfix">
                            <input value="2023-03-06" type="text" name="mulai" id="mulai" class="col-xs-12  col-sm-6 date-picker" placeholder="Tanggal Mulai" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Tanggal Selesai :</label>
                    <div class="col-xs-12 col-sm-3">
                        <div class="clearfix">
                            <input value="2023-07-24" type="text" name="selesai" id="selesai" class="col-xs-12  col-sm-6 date-picker" placeholder="Tanggal Selesai" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Jenis :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="jenis" id="jenis" data-placeholder="---> Pilih Jenis <---">
                                <option value=""> </option>
                                 <?php
                                foreach (array('WAJIB','PILIHAN','KHUSUS') as $val) {
                                    $selected = ($edit['jenis_matkul'] == $val) ? 'selected' : '';
                                    echo '<option value="'.$val.'" '.$selected.'>'.$val.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Status :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="status" id="status" data-placeholder="---> Pilih Status <---">
                                <option value=""> </option>
                                 <?php
                                foreach (load_array('st_opsi') as $val) {
                                    $stt = empty($edit['kuota_kelas']) ? 1:$edit['status_kelas'];
                                    $selected = ($stt == $val['id']) ? 'selected' : '';
                                    echo '<option value="'.$val['id'].'" '.$selected.'>'.$val['txt'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">Kuota :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <input value="<?= empty($edit['kuota_kelas']) ? 35:$edit['kuota_kelas'] ?>" type="number" name="kuota" id="kuota" placeholder="? Mahasiswa" class="col-xs-12  col-sm-6"/>
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
    'backend/assets/js/bootbox.min.js',
    'backend/assets/js/select2.js',
    'backend/assets/js/jquery.validate.js',
    'backend/assets/js/date-time/bootstrap-datepicker.js'
));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";
    const module_do = module + "_do";
    const form = $("#validation-form");
    
    $(document).ready(function () {
        $(".select2").select2({allowClear: true});
        $(".date-picker").datepicker({ format: 'yyyy-mm-dd',autoclose: true, todayHighlight: true, clearBtn: true });
        get_select();
    });
    $("#matkul").change(function () {
        let data = $("#matkul").select2('data');
        $("#txt-matkul").html(data.text);
        $("#kode").val(data.kode);
        $("#namamk").val(data.nama);
        $("#sks").val(data.sks);
    });
</script>
<script type="text/javascript">
    function get_select() {
        $("#matkul").select2({
            placeholder: "------> Pilih Mata Kuliah <------",
            minimumInputLength: 3,
            allowClear: true,
            ajax: {
                url: module + "/ajax/type/list/source/matkul",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function (term) {
                    return {
                        term: term,
                        id: $("#prodi").val()
                    };
                },
                results: function (data) {
                    return {results: data};
                },
                cache: true
            },
            initSelection: function(element, callback) {
                var id = $(element).val();
                if (id !== "") {
                    let text = $("#kode").val() + ' - ' +$("#namamk").val() + ' (' +$("#sks").val() + ' sks)'; 
                    callback({id: id, text: text});
                }
            }
        });
    }
    form.submit(function(){
        if(form.validate().checkForm()){
            var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i>' +
            ' Menyimpan Data . . . </h4>';
            var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                    ' Mohon menunggu, jangan menutup atau me-refresh halaman ini. <br>Silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
            bootbox.dialog({
                title: title,
                message: msg,
                closeButton: false
            });
        }
    });
    form.validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            prodi: {
                required: true
            },
            matkul: {
                required: true
            },
            sks: {
                required: true,
                digits: true,
                min: 1,
                max: 10
            },
            jenis: {
                required: true
            },
            semester: {
                required: true
            },
            nama: {
//                required: true,
                maxlength: 5
            },
            mulai: {
                date: true,
                minlength: 5
            },
            selesai: {
                date: true,
                minlength: 5
            },
            lingkup: {
//                required: true
            },
            mode: {
//                required: true
            },
            status: {
                required: true
            },
            kuota: {
                required: true,
                digits: true,
                min: 1,
                max: 100
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
