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
        <div class="col-xs-12 col-sm-12">
            <p class="is-loading bigger-130 blue hide" align="center"><i class="fa fa-spinner fa-spin fa-fw fa-2x"></i> Loading . . .</p>
            <div class="widget-box transparent">
                <div class="widget-header">
                    <h4 class="widget-title smaller">
                        <i class="ace-icon fa fa-comments blue"></i>
                        <?= $title[1] ?>
                    </h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse" class="orange2">
                            <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                        </a>
                    </div>
                    <div class="widget-toolbar no-border">
                        <div class="btn-group btn-overlap">
                            <button onclick="get_chat()" class="btn btn-white btn-primary btn-sm btn-bold">
                                <i class="fa fa-search-plus bigger-120"></i> Lihat Data
                            </button>
                        </div>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <div class="dialogs ace-scroll">
                            <div class="scroll-track scroll-active">
                                <div class="scroll-bar"></div>
                            </div>
                            <div id="chat-item" class="scroll-content">
                                
                            </div>
                        </div>
                        <form id="chat-form" method="POST" enctype="multipart/form-data">
                            <input value="<?= encode($detail['id_room']) ?>" name="id" type="hidden">
                            <div class="form-actions">
                                <div class="input-group">
                                    <input placeholder="Ketik pesan anda disini ..." type="text" class="form-control" name="message">
                                    <span class="input-group-btn">
                                        <button id="btn-kirim" class="btn btn-sm btn-success no-radius" type="button">
                                            <i class="ace-icon fa fa-paper-plane"></i>
                                            Kirim
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.widget-main -->
                </div><!-- /.widget-body -->
            </div><!-- /.widget-box -->
        </div>
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
        get_chat();
    });
</script>
<script type="text/javascript">
    function get_chat() {
        $(".is-loading").removeClass("hide");
        $.ajax({
            url: module + "/ajax/type/list/source/chat",
            type: "POST",
            dataType: "json",
            data: $("#chat-form").serialize(),
            success: function (rs) {
                $(".is-loading").addClass("hide");
                $(".chat-item").remove();
                if(rs.status) {
                    $("#chat-item").html(rs.data);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $(".is-loading").addClass("hide");
                console.log('Failed fetch data from server');
            }
        });
    }
</script> 
