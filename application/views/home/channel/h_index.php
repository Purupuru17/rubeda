<div class="container-fluid pb-0">
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
                    <h6 class="title"><?= $title ?></h6>
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
    const module = "<?= site_url('home') ?>";  
    $(function () {
        get_channel();
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
    function get_channel(sort = null) {
        $.ajax({
            url: module + "/ajax/type/list/source/channel",
            type: "POST",
            dataType: "json",
            data: { sort: sort, key: $("#q-search").val(), limit: 40, type: $(".title").text() },
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
                console.log(xhr);
            }
        });
    }
</script>