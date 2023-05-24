<div class="container-fluid upload-details">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-title">
                <h6>Unggah Video</h6>
            </div>
        </div>
        <div class="col-lg-2">
            <div id="uploaded-file" class="imgplace"></div>
        </div>
        <div class="col-lg-10">
            <div class="osahan-title"></div>
            <div class="osahan-size">102.6 MB . 2:13 MIN Remaining</div>
            <div class="osahan-progress">
                <div class="progress" style="height: 24px">
                    <div id="file-progress-bar" class="progress-bar progress-bar-success progress-bar-striped progress-bar-animated" role="progressbar"></div>
                </div>
                <div class="osahan-close">
                    <a href="#"><i class="fas fa-times-circle"></i></a>
                </div>
            </div>
            <div id="msg-txt" class="osahan-desc" style="font-size: 14px"></div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <form id="upload-form" method="POST" enctype="multipart/form-data">
            <div class="osahan-form">
                <span id="msg-check"></span>
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>Pilih File</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" placeholder="Judul Video (Buat Semenarik Mungkin)" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea rows="3" name="deskripsi" placeholder="Deskripsi Terkait Video" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="e3">Orientation</label>
                            <select id="e3" class="custom-select">
                                <option>Straight</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="e4">Privacy Settings</label>
                            <select id="e4" class="custom-select">
                                <option>Public</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="e5">Monetize</label>
                            <select id="e5" class="custom-select">
                                <option>Yes</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="e6">License</label>
                            <select id="e6" class="custom-select">
                                <option>Standard</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label for="e7">Tags (13 Tags Remaining)</label>
                            <input type="text" placeholder="Gaming, PS4" id="e7" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="e8">Cast (Optional)</label>
                            <input type="text" placeholder="Nathan Drake," id="e8" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="e9">Language in Video (Optional)</label>
                            <select id="e9" class="custom-select">
                                <option>English</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h6>Category ( you can select upto 6 categories )</h6>
                        </div>
                    </div>
                </div>
                <div class="row category-checkbox">

                    <div class="col-lg-2 col-xs-6 col-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Abaft</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label" for="customCheck2">Brick</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                            <label class="custom-control-label" for="customCheck3">Purpose</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck4">
                            <label class="custom-control-label" for="customCheck4">Shallow</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck5">
                            <label class="custom-control-label" for="customCheck5">Spray</label>
                        </div>
                    </div>

                    <div class="col-lg-2 col-xs-6 col-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="zcustomCheck1">
                            <label class="custom-control-label" for="zcustomCheck1">Cemetery</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="zcustomCheck2">
                            <label class="custom-control-label" for="zcustomCheck2">Trouble</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="zcustomCheck3">
                            <label class="custom-control-label" for="zcustomCheck3">Pin</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="zcustomCheck4">
                            <label class="custom-control-label" for="zcustomCheck4">Fall</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="zcustomCheck5">
                            <label class="custom-control-label" for="zcustomCheck5">Leg</label>
                        </div>
                    </div>

                    <div class="col-lg-2 col-xs-6 col-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="czcustomCheck1">
                            <label class="custom-control-label" for="czcustomCheck1">Scissors</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="czcustomCheck2">
                            <label class="custom-control-label" for="czcustomCheck2">Stitch</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="czcustomCheck3">
                            <label class="custom-control-label" for="czcustomCheck3">Agonizing</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="czcustomCheck4">
                            <label class="custom-control-label" for="czcustomCheck4">Rescue</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="czcustomCheck5">
                            <label class="custom-control-label" for="czcustomCheck5">Quiet</label>
                        </div>
                    </div>

                    <div class="col-lg-2 col-xs-6 col-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Abaft</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label" for="customCheck2">Brick</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                            <label class="custom-control-label" for="customCheck3">Purpose</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck4">
                            <label class="custom-control-label" for="customCheck4">Shallow</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck5">
                            <label class="custom-control-label" for="customCheck5">Spray</label>
                        </div>
                    </div>

                    <div class="col-lg-2 col-xs-6 col-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="zcustomCheck1">
                            <label class="custom-control-label" for="zcustomCheck1">Cemetery</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="zcustomCheck2">
                            <label class="custom-control-label" for="zcustomCheck2">Trouble</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="zcustomCheck3">
                            <label class="custom-control-label" for="zcustomCheck3">Pin</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="zcustomCheck4">
                            <label class="custom-control-label" for="zcustomCheck4">Fall</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="zcustomCheck5">
                            <label class="custom-control-label" for="zcustomCheck5">Leg</label>
                        </div>
                    </div>

                    <div class="col-lg-2 col-xs-6 col-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="czcustomCheck1">
                            <label class="custom-control-label" for="czcustomCheck1">Vessel</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="czcustomCheck2">
                            <label class="custom-control-label" for="czcustomCheck2">Stitch</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="czcustomCheck3">
                            <label class="custom-control-label" for="czcustomCheck3">Agonizing</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="czcustomCheck4">
                            <label class="custom-control-label" for="czcustomCheck4">Rescue</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="czcustomCheck5">
                            <label class="custom-control-label" for="czcustomCheck5">Quiet</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="osahan-area text-center mt-3">
                <button id="btn-submit" class="btn btn-outline-primary" type="submit">Simpan</button>
            </div>
            <hr>
            <div class="terms text-center">
                <p class="mb-0">There are many variations of passages of Lorem Ipsum available, but the majority <a href="#">Terms of Service</a> and <a href="#">Community Guidelines</a>.</p>
                <p class="hidden-xs mb-0">Ipsum is therefore always free from repetition, injected humour, or non</p>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";  
    $(function () {
        
    });
    $("#judul").keyup(function () {
        $(".osahan-title").html(this.value);
    });
    $(document).on('submit', '#upload-form', function(e){
        $("#msg-check").html('');
        e.preventDefault();
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();         
                xhr.upload.addEventListener("progress", function(element) {
                    console.log(element);
                    if (element.lengthComputable) {
                        var percentComplete = ((element.loaded / element.total) * 100);
                        $("#file-progress-bar").width(percentComplete + '%');
                        $("#file-progress-bar").html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url: module + "/ajax/type/action/source/upload",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            beforeSend: function(){
                $("#file-progress-bar").width('0%');
                $("#msg-txt").html('<div class="text-info">Sedang mengupload video. Mohon tetap di halaman ini hingga proses upload selesai!</div>');
            },
            success: function(rs){
                if(rs.status){
                    $("#upload-form")[0].reset();
                    $("#btn-submit").hide();
                    $(".osahan-title").html('');
                    $("#msg-txt").html('<div class="text-success">'+rs.msg+'</div>');
                    $("#uploaded-file").html('<video width="100%" height="94" controls><source src="'+rs.data+'"></video>');
                }else{
                    $("#msg-txt").html('<div class="text-danger">'+rs.msg+'</div>');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
    $("#file").change(function(){
        var allowedTypes = ['video/mp4','video/mkv','video/avi'];
        var file = this.files[0];
        var fileType = file.type;
        if(!allowedTypes.includes(fileType)) {
            $("#msg-check").html('<small class="text-danger">Pilih format video yang sesuai (MP4, MKV, AVI)</small>');
            $("#file").val('');
            return false;
        } else {
            $("#msg-check").html('');
        }
    });
</script>