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
            <p id="dynamic-spin" class="bigger-130 blue" align="center"><i class="fa fa-spinner fa-spin fa-fw fa-2x"></i> Loading . . .</p>
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h5 class="widget-title bigger lighter">
                        <i class="ace-icon fa fa-list"></i>
                        <?= $title[1] ?>
                    </h5>
                    <div class="widget-toolbar no-border">
                        <div class="btn-group btn-overlap">
                            <a href="<?= site_url($module.'/add') ?>" class="btn btn-white btn-primary btn-bold">
                                <i class="fa fa-plus-square bigger-110 blue"></i> Tambah Data
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
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Thumbnail</th>
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
        'backend/assets/js/bootbox.min.js'
    ));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";
    let table;
    $(function() {
        $('[data-rel="tooltip"]').tooltip({placement: 'top'});
        load_table();
        load_data();
    });
    $(document.body).on("click", "#delete-btn", function(event) {
        var id = $(this).attr("name");
        var name = $(this).attr("itemprop");
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
</script>
<script type="text/javascript">
    function load_data() {
        $.ajax({
            url: module + "/ajax/type/table/source/data",
            type: "POST",
            dataType: "json",
            success: function (rs) {
                $("#dynamic-spin").addClass("hide");
                table.fnClearTable();
                $.each(rs.data, function (index, value) {
                    table.fnAddData(value);
                });
                table.fnDraw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $("#dynamic-spin").addClass("hide");
                myNotif('Peringatan', 'Tidak dapat memuat data dengan baik', 3);
            }
        });
    }
    function load_table() {
        table = $("#dynamic-table")
        .dataTable({
            bScrollCollapse: true,
            bAutoWidth: false,
            aaSorting: [],
            aoColumnDefs: [
                {bSortable: false, aTargets: [0,4]},
                {bSearchable: false, aTargets: [0,4]},
                {sClass: "center", aTargets: [0, 1, 2, 3]},
                {sClass: "center nowrap", aTargets: [4]}
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
        table.fnAdjustColumnSizing();
    }
</script>                  
