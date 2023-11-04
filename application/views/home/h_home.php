<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid pb-0">
    <div class="top-mobile-search">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= site_url() ?>" method="GET" class="mobile-search">
                    <div class="input-group">
                        <input value="<?= element('q', $_GET, '') ?>" name="q" type="text" placeholder="Telusuri..." class="form-control">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?= $this->session->flashdata('notif'); ?>
    <div class="top-category section-padding mb-4">
        <div class="row">
            <div class="col-md-12">
                <div class="main-title">
                    <div class="btn-group float-right right-action">
                        <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a id="topik-sort" itemid="most" class="dropdown-item"><i class="fas fa-fw fa-star"></i> &nbsp; Top Video</a>
                            <a id="topik-sort" itemid="asc" class="dropdown-item"><i class="fas fa-fw fa-signal"></i> &nbsp; Terurut</a>
                        </div>
                    </div>
                    <h6>Topik</h6>
                </div>
            </div>
            <div class="col-md-12">
                <div id="topik-item" class="owl-carousel owl-carousel-category"></div>
            </div>
        </div>
    </div>
    <hr>
    <div class="video-block section-padding">
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
                    <h6>Video</h6>
                </div>
            </div>
        </div>
    </div>
    <hr class="mt-0">
    <div class="video-block section-padding">
        <div class="row">
            <div id="channel-item" class="col-md-12">
                <div class="main-title">
                    <div class="btn-group float-right right-action">
                        <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a id="channel-sort" itemid="populer" class="dropdown-item"><i class="fas fa-fw fa-star"></i> &nbsp; Populer</a>
                            <a id="channel-sort" itemid="baru" class="dropdown-item"><i class="fas fa-fw fa-clock"></i> &nbsp; Terbaru</a>
                        </div>
                    </div>
                    <h6>Channel</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    load_js(array(
        'backend/assets/js/bootbox.min.js'
    ));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";  
    $(function () {
        get_topik();
        get_video();
        get_channel();
    });
    $(document.body).on("click", "#topik-sort", function(event) {
        get_topik($(this).attr("itemid"));
    });
    $(document.body).on("click", "#video-sort", function(event) {
        get_video($(this).attr("itemid"));
    });
    $(document.body).on("click", "#channel-sort", function(event) {
        get_channel($(this).attr("itemid"));
    });
    $(document.body).on("click", "#subs-btn", function(event) {
        subs_channel($(this).attr("itemid"), $(this).attr("itemprop"));
        $(this).hide();
    });
</script>
<script type="text/javascript">
    function get_topik(sort = null) {
        $.ajax({
            url: module + "/ajax/type/list/source/topik",
            type: "POST",
            dataType: "json",
            data: { sort: sort, key: $("#q-search").val(), limit: 16 },
            success: function (rs) {
                $(".topik-item").remove();
                if(rs.status) {
                    let content = '';
                    $.each(rs.data, function (index, value) {
                        content = '<div class="item topik-item"><div class="category-item">' +
                            '<a href="'+ value.link +'">' +
                            '<img class="img-fluid" src="'+ value.image +'">' +
                            '<h6>'+ value.judul +'</h6><p>'+ value.video +' Video</p>' +
                        '</a></div></div>';
                        $("#topik-item").owlCarousel().trigger('add.owl.carousel', [$(content)]).trigger('refresh.owl.carousel');
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Failed fetch data from server');
            }
        });
    }
    function get_video(sort = null) {
        $.ajax({
            url: module + "/ajax/type/list/source/video",
            type: "POST",
            dataType: "json",
            data: { sort: sort, key: $("#q-search").val(), limit: 24 },
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
    function get_channel(sort = null) {
        $.ajax({
            url: module + "/ajax/type/list/source/channel",
            type: "POST",
            dataType: "json",
            data: { sort: sort, key: $("#q-search").val(), limit: 8 },
            success: function (rs) {
                $(".channel-item").remove();
                if(rs.status) {
                    $(rs.data).insertAfter("#channel-item");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Failed fetch data from server');
            }
        });
    }
    function subs_channel(id, status){
        $.ajax({
            url: module + "/ajax/type/action/source/subscribe",
            dataType: "json",
            type: "POST",
            data: {
                id: id,
                status: status
            },
            success: function (rs) {
                if (rs.status) {
                    bootbox.alert({ message: rs.msg, backdrop: true });
                    get_channel();
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
