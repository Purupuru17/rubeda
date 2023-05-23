<?php
$this->load->view('sistem/v_breadcrumb');
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            <?= $title[0] ?>
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                <?= $title[1] ?>
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <?= $this->session->flashdata('notif'); ?>
        </div>
        <div class="col-xs-12">
            <form id="search-form" name="form" class="form-horizontal" method="POST">
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-2 no-padding-right">Periode :</label>
                    <div class="col-xs-12 col-sm-3">
                        <div class="clearfix">
                            <select class="select2 width-100" name="periode" id="periode" data-placeholder="------> Pilih Periode <------">
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
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-2 no-padding-right">Program Studi :</label>
                    <div class="col-xs-12 col-sm-3">
                        <div class="clearfix">
                            <select class="select2 width-100" name="prodi" id="prodi" data-placeholder="------> Pilih Program Studi <------">
                                <option value=""> </option>
                                <?php
                                foreach ($prodi['data'] as $val) {
                                    echo '<option value="'.encode($val['id_prodi']).'">'.$val['nama_prodi'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-2 no-padding-right">Semester :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="semester" id="semester" data-placeholder="--> Pilih Semester <--">
                                <option value=""> </option>
                                <?php
                                foreach (array(1,2,3,4,5,6,7,8) as $val) {
                                    echo '<option value="' . $val . '" '.$selected.'>' . $val . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-2 no-padding-right">Dosen :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="praktisi" id="praktisi" data-placeholder="----> Pilih Tipe <----">
                                <option value=""> </option>
                                <option value="1"> TETAP </option>
                                <option value="0"> PRAKTISI </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-6">
                        <button class="btn btn-primary btn-white" name="cari" id="btn-search" type="button">
                            <i class="ace-icon fa fa-search-plus"></i>
                            Pencarian
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xs-12">
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h5 class="widget-title bigger lighter">
                        <i class="ace-icon fa fa-list"></i>
                        <?= $title[1] ?>
                    </h5>
                    <div class="widget-toolbar no-border">
                        <div class="btn-group btn-overlap">
                            <a href="<?= site_url($module.'/add') ?>" class="btn btn-white btn-primary btn-bold">
                                <i class="fa fa-plus-square bigger-120 blue"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-2 table-responsive">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="20%">Program Studi</th>
                                    <th>Mata Kuliah <br/><small class="smaller-70">(Wajib/Pilihan/Khusus)</small></th>
                                    <th>Bobot MK</th>
                                    <th>Kelas <br/><small class="smaller-70">(Semester)</small></th>
                                    <th>Dosen</th>
                                    <th>Peserta</th>
                                    <th>Informasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<?php
    load_js(array(
        'backend/assets/js/dataTables/jquery.dataTables.js',
        'backend/assets/js/dataTables/jquery.dataTables.bootstrap.js',
        'backend/assets/js/bootbox.min.js',
        'backend/assets/js/select2.js'
    ));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";
    let table;
    
    $(document).ready(function () {
        $('[data-rel="tooltip"]').tooltip({placement: 'top'});
        $(".select2").select2({allowClear: true});
        $(".select2-chosen").addClass("center");
        load_table();
    });
    $(document.body).on("click", "#delete-btn", function(event) {
        var id = $(this).attr("itemid");
        var name = $(this).attr("itemname");
        var title = "<h4 class='red center'><i class='ace-icon fa fa-exclamation-triangle red'></i>" + 
                " Peringatan !</h4>";
        var msg = "<p class='center grey bigger-120'><i class='ace-icon fa fa-hand-o-right blue'></i>" + 
                " Apakah anda yakin akan menghapus data <br/><b>" + name + "</b> ? </p>";
        bootbox.confirm({
            title: title,
            message: msg, 
            buttons: {
                cancel: {
                    label: "<i class='ace-icon fa fa-times bigger-110'></i> Batal",
                    className: "btn btn-sm"
                },
                confirm: {
                    label: "<i class='ace-icon fa fa-trash-o bigger-110'></i> Hapus",
                    className: "btn btn-sm btn-danger"
                }
            },
            callback: function(result) {
                if (result === true) {
                    window.location.replace(module + "/delete/" + id);
                }
            }
        });
    });
    $(document.body).on("click", "#check-btn", function(event) {
        check_kelas($(this).attr("itemid"));
    });
    function check_kelas(id){
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
            url: module + "/ajax/type/list/source/check",
            dataType: "json",
            type: "POST",
            data: {
                id: id
            },
            success: function (rs) {
                progress.modal("hide");
                if (rs.status) {
                    myNotif('Informasi', rs.msg, 1);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
                table.fnDraw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                myNotif('Error', 'Kesalahan jaringan. Mohon ulangi proses', 3);
            }
        });
    }
    function load_table() {
        table = $("#dynamic-table")
        .dataTable({
            bScrollCollapse: true,
            bAutoWidth: false,
            bProcessing: true,
            bServerSide: true,
            ajax: {
                url: module + "/ajax/type/table/source/data",
                type: "POST",
                dataType: "json",
                data: function (val) {
                    val.periode = $("#periode").val();
                    val.prodi = $("#prodi").val();
                    val.semester = $("#semester").val();
                    val.praktisi = $("#praktisi").val();
                }
            },
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0,8]},
                {bSearchable: false, aTargets: [0,8]},
                {sClass: "center", aTargets: [0, 1, 3, 4, 5, 6, 7]},
                {sClass: "center nowrap", aTargets: [2,8]}
            ],
            oLanguage: {
                sSearch: "Cari : ",
                sInfoEmpty: "Menampilkan dari 0 sampai 0 dari total 0 data",
                sInfo: "Menampilkan dari _START_ sampai _END_ dari total _TOTAL_ data",
                sLengthMenu: "_MENU_ data per halaman",
                sZeroRecords: "Maaf tidak ada data yang ditemukan",
                sInfoFiltered: "(Menyaring dari _MAX_ total data)",
                sProcessing: "<i class='fa fa-spinner fa-spin fa-fw fa-2x'></i> Loading . . ."
            }
        });
        table.fnAdjustColumnSizing();
    }
    $("#btn-search").click(function () { //button filter event click
        table.fnDraw();  //just reload table
    });
</script>