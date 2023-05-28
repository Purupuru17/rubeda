<div class="container-fluid">
    <div class="video-block section-padding">
        <div class="row">
            <div id="topik-item" class="col-md-12">
                <div class="main-title">
                    <div class="btn-group float-right right-action">
                        <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a id="topik-sort" itemid="most" class="dropdown-item"><i class="fas fa-fw fa-star"></i> &nbsp; Top Video</a>
                            <a id="topik-sort" itemid="asc" class="dropdown-item"><i class="fas fa-fw fa-signal"></i> &nbsp; Terurut</a>
                        </div>
                    </div>
                    <h6>Topik</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    const home = "<?= site_url('home') ?>";  
    $(function () {
        get_topik();
    });
    $(document.body).on("click", "#topik-sort", function(event) {
        get_topik($(this).attr("itemid"));
    });
</script>
<script type="text/javascript">
    function get_topik(sort = null) {
        $.ajax({
            url: home + "/ajax/type/list/source/topik",
            type: "POST",
            dataType: "json",
            data: { sort: sort, key: $("#q-search").val(), limit: 40 },
            success: function (rs) {
                $(".topik-item").remove();
                if(rs.status) {
                    $(rs.content).insertAfter("#topik-item");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Failed fetch data from server');
            }
        });
    }
</script>