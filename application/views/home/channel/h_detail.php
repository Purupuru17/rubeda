<div class="single-channel-page" >
    <div class="single-channel-image">
        <img class="img-fluid" alt src="<?= load_file('app/img/channel-banner.png') ?>">
        <div class="channel-profile">
            <img class="channel-profile-img" alt src="<?= load_file($detail['img_creator']) ?>">
            <div class="social hidden-xs">
<!--                <a class="gp" href="#">Whatsapp</a>
                <a class="fb" href="#">Facebook</a>
                <a class="tw" href="#">Twitter</a>-->
            </div>
        </div>
    </div>
    <div class="single-channel-nav">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="channel-brand" href="#"><?= $detail['nama_creator'] ?>
                <span title data-placement="top" data-toggle="tooltip" data-original-title="Verified">
                    <i class="fas fa-check-circle text-success"></i>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Videos <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <form action="#" class="form-inline my-2 my-lg-0">
                    <input class="form-control form-control-sm mr-sm-1" type="search" id="search" placeholder="Cari disini" aria-label="Search">
                    <button onclick="get_video()" class="btn btn-outline-success btn-sm my-2 my-sm-0" type="button"><i class="fas fa-search"></i></button> &nbsp;&nbsp;&nbsp; 
                    <?= $button_subs ?>
                </form>
            </div>
        </nav>
    </div>
    <div class="container-fluid">
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
                        <h6>Videos</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="<?= encode($detail['id_creator']) ?>" id="id">
<?php
    load_js(array(
        'backend/assets/js/bootbox.min.js'
    ));
?>
<script type="text/javascript">
    const module = "<?= site_url('home') ?>";
    $(function () {
        get_video();
    });
    $(document.body).on("click", "#video-sort", function(event) {
        get_video($(this).attr("itemid"));
    });
    $(document.body).on("click", "#subs-btn", function(event) {
        subs_channel($(this).attr("itemid"), $(this).attr("itemprop"));
        $(this).hide();
    });
</script>
<script type="text/javascript">
    function get_video(sort = null) {
        $.ajax({
            url: module + "/ajax/type/list/source/video",
            type: "POST",
            dataType: "json",
            data: { sort: sort, key: $("#search").val(), limit: 40, type: 'channel', value: $("#id").val() },
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