<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid pb-0">
    <div class="top-mobile-search">
        <div class="row">
            <div class="col-md-12">
                <form class="mobile-search">
                    <div class="input-group">
                        <input type="text" placeholder="Search for..." class="form-control">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-dark"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";  
    $(function () {
        get_topic();
        get_video();
        get_channel();
    });
    $(document.body).on("click", "#topik-sort", function(event) {
        get_topic($(this).attr("itemid"));
    });
    $(document.body).on("click", "#video-sort", function(event) {
        get_video($(this).attr("itemid"));
    });
    $(document.body).on("click", "#channel-sort", function(event) {
        get_channel($(this).attr("itemid"));
    });
</script>
<script type="text/javascript">
    function get_topic(sort = null) {
        $.ajax({
            url: module + "/ajax/type/list/source/topic",
            type: "POST",
            dataType: "json",
            data: { sort: sort },
            success: function (rs) {
                if(rs.status) {
                    let content = '';
                    $.each(rs.data, function (index, value) {
                        content = '<div class="item"><div class="category-item">' +
                            '<a href="'+ value.link +'">' +
                            '<img class="img-fluid" src="'+ value.image +'">' +
                            '<h6>'+ value.judul +'</h6><p>'+ value.video +' Video</p>' +
                        '</a></div></div>';
                        $("#topik-item").owlCarousel().trigger('add.owl.carousel', [$(content)]).trigger('refresh.owl.carousel');
                    });
                }else{
                    $("#topik-item").html('');
                    console.log(rs.msg);
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
            data: { sort: sort },
            success: function (rs) {
                if(rs.status) {
                    $("#video-item").next().remove();
                    $(rs.data).insertAfter("#video-item");
                }else{
                    $("#video-item").next().remove();
                    console.log(rs.msg);
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
            data: { sort: sort },
            success: function (rs) {
                if(rs.status) {
                    $("#channel-item").next().remove();
                    $(rs.data).insertAfter("#channel-item");
                }else{
                    $("#channel-item").next().remove();
                    console.log(rs.msg);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Failed fetch data from server');
            }
        });
    }
</script>