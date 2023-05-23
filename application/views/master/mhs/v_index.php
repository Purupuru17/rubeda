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
            <form id="search-form" name="form" action="<?= site_url($module.'/export') ?>" class="form-horizontal" method="POST">
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-2 no-padding-right">Program Studi :</label>
                    <div class="col-xs-12 col-sm-3">
                        <div class="clearfix">
                            <select class="select2 width-100" name="prodi" id="prodi" data-placeholder="------> Pilih Program Studi <------">
                                <option value=""> </option>
                                <?php
                                foreach ($prodi['data'] as $val) {
                                    $selected = ($prodi_id == $val['id_prodi']) ? 'selected' : '';
                                    echo '<option value="'.encode($val['id_prodi']).'" '.$selected.'>'.$val['nama_prodi'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-2 no-padding-right">Angkatan :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="tahun" id="tahun" data-placeholder="---> Pilih Tahun <---">
                                <option value=""> </option>
                                <?php
                                foreach (load_array('tahun') as $val) {
                                    echo '<option value="'.$val.'">'.$val.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-2 no-padding-right">Status :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="status" id="status" data-placeholder="---> Pilih Status <---">
                                <option value=""> </option>
                                <?php
                                foreach (load_array('st_mhs') as $val) {
                                    echo '<option value="'.$val.'">'.$val.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group <?= $this->session->userdata('level') > 100 ? '':'hide' ?>">
                    <label class="control-label col-xs-12 col-sm-2 no-padding-right">AKM <?= $this->session->userdata('namasmt') ?> :</label>
                    <div class="col-xs-12 col-sm-2">
                        <div class="clearfix">
                            <select class="select2 width-100" name="akm" id="akm" data-placeholder="--> Pilih Periode <--">
                                <option value=""> </option>
                                <option value="<?= $this->session->userdata('idsmt') ?>"> YA </option>
                                <option value="1"> TIDAK </option>
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
                        <button class="btn btn-success btn-white" name="export" id="btn-export" type="submit">
                            <i class="ace-icon fa fa-file-excel-o"></i>
                            Export
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
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-2 table-responsive">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Nama Lengkap</th>
                                    <th>Program Studi</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
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
        'backend/assets/js/select2.js',
        'backend/assets/js/bootbox.min.js'
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
    function load_table() {
        table = $("#dynamic-table")
        .dataTable({
            orderCellsTop: true,
            fixedHeader: true,
            bScrollCollapse: true,
            bAutoWidth: false,
            bProcessing: true,
            bServerSide: true,
            ajax: {
                url: module + "/ajax/type/table/source/mhs",
                type: "POST",
                dataType: "json",
                data: function (val) {
                    val.prodi = $("#prodi").val();
                    val.tahun = $("#tahun").val();
                    val.status = $("#status").val();
                    val.akm = $("#akm").val();
                }
            },
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0,6]},
                {bSearchable: false, aTargets: [0,6]},
                {sClass: "center", aTargets: [0, 1, 2, 3, 4, 5]},
                {sClass: "center nowrap", aTargets: [6]}
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
