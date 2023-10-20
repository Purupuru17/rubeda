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
        <div class="col-xs-12 col-sm-6">
            <p class="is-loading bigger-130 blue hide" align="center"><i class="fa fa-spinner fa-spin fa-fw fa-2x"></i> Loading . . .</p>
            <div class="widget-box transparent">
                <div class="widget-header">
                    <h5 class="widget-title">
                        <i class="ace-icon fa fa-comments"></i>
                        Riwayat Obrolan
                    </h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-2 table-responsive">
                        <div id="room-item" class="clearfix">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
        <div class="col-xs-12 col-sm-6">
            <p class="is-loading2 bigger-130 blue hide" align="center"><i class="fa fa-spinner fa-spin fa-fw fa-2x"></i> Loading . . .</p>
            <div class="widget-box transparent">
                <div class="widget-header">
                    <h5 class="widget-title green">
                        <i class="ace-icon fa fa-users"></i>
                        Online
                    </h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-18 table-responsive">
                        <div id="user-item" class="profile-users clearfix">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<?php
    load_js(array(
        'backend/assets/js/bootbox.min.js'
    ));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";
    $(function() {
        $('[data-rel="tooltip"]').tooltip({placement: 'top'});
        get_room();
        get_user();
        
        setInterval(function() {
            get_room();
            console.log('Fetch new notification');
        }, 10000);
    });
    $(document.body).on("click", "#restart-btn", function(event) {
        var id = $(this).attr("itemid");
        var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i>' +
                ' Mohon tunggu . . . </h4>';
        var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                ' Jangan menutup atau me-refresh halaman ini, silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
        var progress = bootbox.dialog({title: title, message: msg, closeButton: false });
        setInterval(function() {
            progress.modal("hide");
            window.location.replace(module + "/add/" + id);
        }, 1000);
    });
    $(document.body).on("click", "#start-btn", function(event) {
        var id = $(this).attr("itemid");
        var name = $(this).attr("itemname");
        var title = "<h4 class='blue center'><i class='ace-icon fa fa-exclamation-triangle blue'></i> Informasi</h4>";
        var msg = "<p class='center grey bigger-120'><i class='ace-icon fa fa-hand-o-right blue'></i>" + 
                " Apakah anda akan memulai obrolan dengan <br/><b>" + name + "</b> ? </p>";
        bootbox.confirm({
            title: title, message: msg, 
            buttons: {
                cancel: {
                    label: "<i class='ace-icon fa fa-times bigger-110'></i> Batal", className: "btn btn-sm"
                },
                confirm: {
                    label: "<i class='ace-icon fa fa-check bigger-110'></i> Ya, Mulai", className: "btn btn-success"
                }
            },
            callback: function(result) {
                if (result === true) {
                    start_room(id);
                }
            }
        });
    });
</script>
<script type="text/javascript">
    function get_room() {
        $(".is-loading").removeClass("hide");
        $.ajax({
            url: module + "/ajax/type/list/source/room",
            type: "POST",
            dataType: "json",
            data: { },
            success: function (rs) {
                $(".is-loading").addClass("hide");
                $(".room-item").remove();
                if(rs.status) {
                    $("#room-item").html(rs.data);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $(".is-loading").addClass("hide");
                console.log('Failed fetch data from server');
            }
        });
    }
    function get_user() {
        $(".is-loading2").removeClass("hide");
        $.ajax({
            url: module + "/ajax/type/list/source/user",
            type: "POST",
            dataType: "json",
            data: { },
            success: function (rs) {
                $(".is-loading2").addClass("hide");
                $(".user-item").remove();
                if(rs.status) {
                    $("#user-item").html(rs.data);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $(".is-loading2").addClass("hide");
                console.log('Failed fetch data from server');
            }
        });
    }
    function start_room(id){
        var title = '<h4 class="blue center"><i class="ace-icon fa fa fa-spin fa-spinner"></i>' +
                ' Mohon tunggu . . . </h4>';
        var msg = '<p class="center red bigger-120"><i class="ace-icon fa fa-hand-o-right blue"></i>' +
                ' Jangan menutup atau me-refresh halaman ini, silahkan tunggu sampai peringatan ini tertutup sendiri. </p>';
        var progress = bootbox.dialog({title: title, message: msg, closeButton: false });
        $.ajax({
            url: module + "/ajax/type/action/source/room",
            dataType: "json",
            type: "POST",
            data: {
                id: id
            },
            success: function (rs) {
                if (rs.status) {
                    setInterval(function() {
                        progress.modal("hide");
                        window.location.replace(module + "/add/" + rs.data);
                    }, 2000);
                    myNotif('Informasi', rs.msg, 1);
                } else {
                    progress.modal("hide");
                    myNotif('Peringatan', rs.msg, 2);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                progress.modal("hide");
                console.log('Failed fetch data from server');
            }
        });
    }
</script>                  
