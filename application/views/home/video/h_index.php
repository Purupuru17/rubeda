<div class="container-fluid pb-0">
    <div class="video-block section-padding">
        <div class="row">
            <div class="col-md-8">
                <div class="single-video-left">
                    <div class="single-video">
                        <video width="100%" height="315" controls>
                            <source src="<?= base_url($detail['file_video']) ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="single-video-title box mb-3">
                        <h2><?= ctk($detail['judul_video']) ?></h2>
                        <p class="mb-0 txt-view"></p>
                    </div>
                    <div class="single-video-author box mb-3">
                        <div class="float-right btn-status"></div>
                        <img class="img-fluid" src="<?= load_file($detail['img_creator']) ?>" alt>
                        <p><a href="<?= site_url('channel/'.$detail['slug_creator']) ?>"><strong><?= $detail['nama_creator'] ?></strong></a> 
                            <span title data-placement="top" data-toggle="tooltip" data-original-title="Verified">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                        </p>
                        <small>Upload pada <?= selisih_wkt($detail['create_video']) ?></small>
                    </div>
                    <div class="single-video-info-content box mb-3">
<!--                        <h6>Privasi :</h6>
                        <p><?= ($detail['privasi_video'] == '1' ? 'PUBLIC' : 'PRIVATE') ?></p>
                        
                        <h6>Batasan Usia :</h6>
                        <p><?= array_find($detail['usia_video'], load_array('st_usia')) ?></p>-->
                        
                        <h6>Topik :</h6>
                        <p><?= $detail['judul_topik'] ?></p>
                        
                        <h6>Deskripsi :</h6>
                        <p><?= ctk($detail['deskripsi_video']) ?></p>
                        
                        <h6>Tags :</h6>
                        <p class="tags mb-0">
                            <?php
                            $tag_arr = explode(',', $detail['tag_video']);
                            for ($i=0; $i < count($tag_arr); $i++) {
                                echo '<span><a href="#">'.$tag_arr[$i].'</a></span> ';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="single-video-right">
                    <div class="row">
                        <div id="video-item" class="col-md-12">
                            <div class="main-title">
                                <div class="btn-group float-right right-action">
                                    <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a id="video-sort" itemid="like" class="dropdown-item"><i class="fas fa-fw fa-star"></i> &nbsp; Top Like</a>
                                        <a id="video-sort" itemid="view" class="dropdown-item"><i class="fas fa-fw fa-signal"></i> &nbsp; Top Viewed</a>
                                        <a id="video-sort" itemid="baru" class="dropdown-item"><i class="fas fa-fw fa-clock"></i> &nbsp; Terbaru</a>
                                    </div>
                                </div>
                                <h6>Video Lainnya</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="id" value="<?= encode($detail['id_video']) ?>">
<input type="hidden" id="cid" value="<?= encode($detail['creator_id']) ?>">
<?php
    load_js(array(
        'backend/assets/js/bootbox.min.js'
    ));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";
    const module_home = "<?= site_url('home') ?>";
    $(function () {
        get_info();
        get_video();
    });
    $(document.body).on("click", "#video-sort", function(event) {
        get_video($(this).attr("itemid"));
    });
    $(document.body).on("click", "#subs-btn", function(event) {
        subs_channel($(this).attr("itemid"), $(this).attr("itemprop"));
    });
    $(document.body).on("click", "#like-btn", function(event) {
        like_video($(this).attr("itemprop"),'like');
    });
    $(document.body).on("click", "#unlike-btn", function(event) {
        like_video($(this).attr("itemprop"),'unlike');
    });
</script>
<script type="text/javascript">
    function get_info() {
        $.ajax({
            url: module + "/ajax/type/list/source/info",
            type: "POST",
            dataType: "json",
            data: { id: $("#id").val(), cid: $("#cid").val() },
            success: function (rs) {
                if(rs.status) {
                    $(".txt-view").html('<i class="fas fa-eye"></i> '+ rs.data.viewed +' views');
                    $(".btn-status").html(rs.data.btn_subs + ' ' + rs.data.btn_like);
                }
                console.log(rs);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Failed fetch data from server');
            }
        });
    }
    function get_video(sort = null) {
        $.ajax({
            url: module_home + "/ajax/type/list/source/video",
            type: "POST",
            dataType: "json",
            data: { sort: sort, key: $("#q-search").val(), limit: 10, type: 'video', value: $("#cid").val() },
            success: function (rs) {
                $(".video-item").remove();
                if(rs.status) {
                    $(rs.data).insertAfter("#video-item");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Failed fetch data from server');
            }
        });
    }
    function subs_channel(id, status){
        $.ajax({
            url: module_home + "/ajax/type/action/source/subscribe",
            dataType: "json",
            type: "POST",
            data: {
                id: id,
                status: status
            },
            success: function (rs) {
                if (rs.status) {
                    bootbox.alert({ message: rs.msg, backdrop: true });
                    get_info();
                } else {
                    bootbox.alert({ message: rs.msg, backdrop: true });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Failed fetch data from server');
            }
        });
    }
    function like_video(status, btn){
        $.ajax({
            url: module + "/ajax/type/action/source/liked",
            dataType: "json",
            type: "POST",
            data: {
                id: $("#id").val(),
                status: status,
                btn: btn
            },
            success: function (rs) {
                if (rs.status) {
                    bootbox.alert({ message: rs.msg, backdrop: true });
                    get_info();
                } else {
                    bootbox.alert({ message: rs.msg, backdrop: true });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Failed fetch data from server');
            }
        });
    }
</script>