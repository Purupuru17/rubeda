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
                    <h6 class="title"></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="type" value="<?= is_array($type) ? element(0,$type) : $type ?>">
<input type="hidden" id="id" value="<?= element(1,$type) ?>">
<script type="text/javascript">
    const module = "<?= site_url('home') ?>";
    const type = $("#type").val();
    $(function () {
        get_video();
        if(type === 'riwayat'){ title = 'Riwayat'; }else if(type === 'like'){ title = 'Video Disukai'; }
        else if(type === 'profil'){ title = 'Video Anda'; }else{ title = type; }
        $(".title").html(title);
    });
    $(document.body).on("click", "#video-sort", function(event) {
        get_video($(this).attr("itemid"));
    });
</script>
<script type="text/javascript">
    function get_video(sort = null) {
        $.ajax({
            url: module + "/ajax/type/list/source/video",
            type: "POST",
            dataType: "json",
            data: { sort: sort, key: $("#q-search").val(), limit: 40, type: type, value: $("#id").val() },
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
</script>