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
                        <?= $title[0] ?>
                    </h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse" class="orange2">
                            <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                        </a>
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
                                    <input name="message" id="message" placeholder="Ketik pesan anda disini ..." type="text" class="form-control">
                                    <span class="input-group-btn">
                                        <button onclick="send_chat()" id="btn-kirim" class="btn btn-sm btn-success no-radius" type="button">
                                            <i class="ace-icon fa fa-paper-plane"></i>
                                            Kirim
                                        </button>
                                        <button id="btn-add" class="btn btn-sm btn-default no-radius" type="button">
                                            <i class="ace-icon fa fa-paperclip"></i>
                                            Lampirkan
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
<div id="modal-add" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header no-padding">
                <div class="table-header">
                    <button type="button" class="close remove" data-dismiss="modal" aria-hidden="true">
                        <span class="white">&times;</span>
                    </button>
                    <div align="center" class="bolder bigger-110">Lampiran</div>
                </div>
            </div>
            <div class="modal-body padding-10">
                <form id="attach-form" action="#" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <input value="<?= encode($detail['id_room']) ?>" name="id" type="hidden">
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right"></label>
                        <div class="col-xs-12 col-sm-7">
                            <div class="clearfix">
                                <input accept="*" value="" type="file" name="attach" id="attach" placeholder="Upload File" class="col-xs-12  col-sm-6" />
                            </div>
                        </div>
                        <span class="help-inline col-xs-12 col-sm-2">
                            <span class="middle red">* Maksimal 1 MB</span>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-1 no-padding-right"></label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="clearfix" id="file-preview">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix form-actions">
                        <div class="col-sm-offset-5 col-xs-offset-4 col-sm-6">
                            <button class="btn hide" type="reset">
                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                Batal
                            </button>
                            &nbsp; &nbsp; &nbsp;
                            <button class="btn btn-success btn-sm" name="simpan" id="btn-upload" type="submit">
                                <i class="ace-icon fa fa-upload"></i>
                                Unggah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php
    load_js(array(
        'backend/assets/js/bootbox.min.js'
    ));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";
    const form = $("#attach-form");
    
    $(function() {
        $('[data-rel="tooltip"]').tooltip({placement: 'top'});
        get_chat();
        
        setInterval(function() {
            get_chat();
            console.log('Fetch new message');
        }, 5000);
        
        $("#attach").ace_file_input({
            no_file: 'Pilih File ...',
            no_icon: 'fa fa-file-o',
            icon_remove: 'fa fa-times',
            btn_choose: 'Pilih',
            btn_change: 'Ubah',
            allowExt: ["jpg", "png", "jpeg", "PNG", "JPG", "pdf", "PDF"],
            maxSize: 1100000,
            before_change: function(files, dropped){
                var valid = false;
                if(files && files[0]) {
                  var reader = new FileReader();
                  reader.onload = function(e) {
                    $("#file-preview").html('<iframe width="100%" src="'+ e.target.result +'" ></iframe>');
                  };
                  reader.readAsDataURL(files[0]);
                  valid = true;
                } else {
                  $("#file-preview").html('');
                }
                return valid;
            }
        }).on('file.error.ace', function(ev, info) {
            if(info.error_count['ext']) myNotif('Peringatan!', 'Jenis file hanya gambar dan pdf', 3);
            if(info.error_count['size']) myNotif('Peringatan!', 'Ukuran file maksimal 1 MB', 3);
        });
        $('.remove').click(function (e) {
            $("#file-preview").html('');
            $("#attach").ace_file_input('reset_input');
        });
    });
    $(document.body).on("click", "#btn-add", function(event) {
        $("#modal-add").modal({backdrop: 'static',keyboard: false});
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
    function send_chat(){
        $.ajax({
            url: module + "/ajax/type/action/source/chat",
            dataType: "json",
            type: "POST",
            data: $("#chat-form").serialize(),
            success: function (rs) {
                if (rs.status) {
                    get_chat();
                    $("#message").val('');
                    myNotif('Informasi', rs.msg, 1);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Failed fetch data from server');
            }
        });
    }
    form.submit(function(e){
        e.preventDefault();
        $.ajax({
            url: module + "/ajax/type/action/source/attach",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $("#file-preview").html('<i class="fa fa-spinner fa-spin fa-fw bigger-130"></i> Uploading...');
            },
            success: function (rs) {
                if (rs.status) {
                    get_chat();
                    
                    $("#message").val('');
                    $("#modal-add").modal('hide');
                    $("#file-preview").html('');
                    $("#attach").ace_file_input('reset_input');
                    myNotif('Informasi', rs.msg, 1);
                } else {
                    myNotif('Peringatan', rs.msg, 2);
                }
            },
            error: function (result, status, e) {
                console.log(result.responseText);
            }
        });
    });
</script> 
