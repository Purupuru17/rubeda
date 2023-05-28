<div class="container-fluid upload-details">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-title">
                <h6>Unggah Video</h6>
            </div>
        </div>
        <div class="col-lg-3">
            <div id="uploaded-file" class="imgplace" style="height: 130px"></div>
        </div>
        <div class="col-lg-9">
            <div class="osahan-title text-primary">?</div>
            <div class="osahan-size text-danger">?</div>
            <div class="osahan-progress">
                <div class="progress" style="height: 28px">
                    <div id="file-progress-bar" class="progress-bar progress-bar-success progress-bar-striped progress-bar-animated" role="progressbar"></div>
                </div>
                <div class="osahan-close">
                    <a id="cancel-up" href="#"><i class="fas fa-times-circle"></i></a>
                </div>
            </div>
            <div class="osahan-desc"></div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <p id="msg-check" class="text-center"></p>
            <form id="upload-form" name="form" method="POST" enctype="multipart/form-data">
            <div class="osahan-form">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Pilih Video <small class="text-primary">(*.mp4)</small></label>
                            <input required="" type="file" name="file" id="file" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Pilih Thumbnail Video <small class="text-primary">(*.jpg, *.jpeg, *.png)</small></label>
                            <input required="" type="file" name="thumb" id="thumb" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Judul <small class="text-primary">(min. 5 karakter)</small></label>
                            <input minlength="5" required="" type="text" name="judul" id="judul" placeholder="Judul Video" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Deskripsi <small class="text-primary">(min. 30 karakter)</small></label>
                            <textarea minlength="30" required="" rows="3" name="deskripsi" placeholder="Deskripsi Video" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Topik</label>
                            <select required="" name="topik" class="custom-select text-center">
                                <option value="">---> Pilih Opsi <---</option>
                                <?php
                                foreach ($topik as $value) {
                                    echo '<option value="'.encode($value['id_topik']).'">'.$value['judul_topik'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Batasan Usia</label>
                            <select required="" name="usia" class="custom-select text-center">
                                <option value="">---> Pilih Opsi <---</option>
                                <?php
                                foreach (load_array('st_usia') as $val) {
                                    echo '<option value="'.$val['id'].'">'.$val['txt'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Pengaturan Privasi</label>
                            <select required="" name="privasi" class="custom-select text-center">
                                <option value="">---> Pilih Opsi <---</option>
                                <option value="1">PUBLIC</option>
                                <option value="2">PRIVATE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Tags</label>
                            <input name="tag" type="text" placeholder="ex : Gaming, Rock, Ronaldo, Butterfly" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="osahan-area text-center mt-3">
                <button id="btn-submit" class="btn btn-outline-primary" type="submit">Simpan</button>
            </div>
            <hr>
            <div class="terms text-center osahan-desc"></div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";
    $("#judul").keyup(function () {
        $(".osahan-title").html(this.value);
    });
    $("#file").change(function(){
        var allowedTypes = ['video/mp4'];
        var file = this.files[0];
        var fileType = file.type;
        if(!allowedTypes.includes(fileType)) {
            $("#msg-check").html('<small class="text-danger">Pilih format video yang sesuai (*.mp4)</small>');
            $("#file").val('');
            return false;
        } else {
            $("#uploaded-file").html('<video width="100%" height="130" controls><source src="'+ URL.createObjectURL(file) +'"></video>');
            $(".osahan-size").html('Ukuran : ' + toSize(file.size));
            $("#msg-check").html('');
        }
    });
    $("#thumb").change(function(){
        var allowedTypes = ['image/jpg','image/jpeg','image/png'];
        var file = this.files[0];
        var fileType = file.type;
        if(!allowedTypes.includes(fileType)) {
            $("#msg-check").html('<span class="text-danger">Pilih format thumbnail (gambar) yang sesuai (*.jpg, *.png)</span>');
            $("#thumb").val('');
            return false;
        } else {
            $("#msg-check").html('');
        }
    });
    function toSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }
    
    $("#upload-form").on('submit', function (e) {
        e.preventDefault();
        var startTime = new Date().getTime();
        var xhr = $.ajax({
            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (e) {
                    if (e.lengthComputable) {
                        var percentComplete = ((e.loaded / e.total) * 100);
                        // calculate data transfer per sec
                        var time = ( new Date().getTime() - startTime ) / 1000;
    	                var bps = e.loaded / time;
                        var Mbps = Math.floor(bps / (1024*1024));
                        // calculate remaining time
                        var remTime = (e.total - e.loaded) / bps;
                        var seconds = Math.floor(remTime % 60);
                        var minutes = Math.floor(remTime / 60);
                        
                        $(".osahan-size").html(`${toSize(e.loaded)} / ${toSize(e.total)} [${Mbps} Mbps] <br>Sisa waktu : ${minutes} menit ${seconds} detik`);
                        $("#file-progress-bar").width(percentComplete + '%');
                        $("#file-progress-bar").html('' + percentComplete + ' %');
                        $(".osahan-desc").html("Terupload " + toSize(e.loaded) + " dari total " + toSize(e.total));
                        // cancel button only work when file is uploading
                        if(percentComplete > 0 && percentComplete < 100){
                            $("#cancel-up").show();
                        }else{
                            $("#cancel-up").hide();
                        }
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url: module + "/ajax/type/action/source/upload",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $("#msg-check").html('');
                $("#upload-form").hide();
                $("#file-progress-bar").width('0%');
                $(".osahan-desc").html('<div class="text-info">Sedang mengupload video. Mohon tetap di halaman ini hingga proses upload selesai!</div>');
            },
            error: function (response, status, e) {
                $("#upload-form").show();
                $(".osahan-desc").html('<div class="text-danger">'+response+'</div>');
            },
            success: function (rs) {
                if(rs.status){
                    $("#upload-form")[0].reset();
                    $(".osahan-title, #uploaded-file").html('');
                    $(".osahan-desc").html('<div class="text-success">'+rs.msg+' Muat ulang halaman ini apabila ingin mengunggah video lainnya.</div>');
                }else{
                    $("#upload-form").show();
                    $(".osahan-desc").html('<div class="text-danger">'+rs.msg+'</div>');
                }
            }
        });
        // for cancel file transfer
        $("#cancel-up").on("click", () => {
            xhr.abort().then(
                $("#file-progress-bar").width('0%'),
                $(".osahan-desc").html('<div class="text-danger">Upload video di batalkan</div>')
            )
        });
    });
</script>