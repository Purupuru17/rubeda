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
            <div class="osahan-title text-primary">?</div>
            <div class="osahan-size text-danger">?</div>
            <div class="osahan-progress">
                <div class="progress" style="height: 28px">
                    <div id="file-progress-bar" class="progress-bar progress-bar-success progress-bar-striped progress-bar-animated" role="progressbar"></div>
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
                                <option value="0">Umum</option>
                                <option value="1">Dewasa</option>
                                <option value="2">Remaja</option>
                                <option value="3">Anak-Anak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Pengaturan Privasi</label>
                            <select required="" name="privasi" class="custom-select text-center">
                                <option value="">---> Pilih Opsi <---</option>
                                <option value="1">Public</option>
                                <option value="2">Private</option>
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
<?php
load_js(array(
    'backend/assets/js/jquery.form.min.js',
));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";  
    $("#judul").keyup(function () {
        $(".osahan-title").html(this.value);
    });
    $("#upload-form").submit(function(e) {
        e.preventDefault();
        $("#msg-check").html('');
        $("#btn-submit").hide();
        $(this).ajaxSubmit({
            url: module + "/ajax/type/action/source/upload",
            target: '#uploaded-file',
            beforeSubmit: function () {
                $("#file-progress-bar").width('0%');
                $(".osahan-desc").html('<div class="text-info">Sedang mengupload video. Mohon tetap di halaman ini hingga proses upload selesai!</div>');
            },
            uploadProgress: function (event, position, total, percentComplete) {
                $("#file-progress-bar").width(percentComplete + '%');
                $("#file-progress-bar").html('' + percentComplete + ' %');
                $(".osahan-desc").html("Terupload " + toSize(position) + " dari total " + toSize(total));
            },
            success: function(rs){
                if(rs.status){
                    $("#upload-form")[0].reset();
                    $(".osahan-title, .osahan-size").html('');
                    $(".osahan-desc").html('<div class="text-success">'+rs.msg+' Mohon tunggu halaman akan dimuat ulang.</div>');
                    $("#uploaded-file").html('<video width="100%" height="94" controls><source src="'+rs.data+'"></video>');
                    setTimeout(function() {location.reload();}, 3000);
                }else{
                    $("#btn-submit").show();
                    $(".osahan-desc").html('<div class="text-danger">'+rs.msg+'</div>');
                }
            },
            error: function (response, status, e) {
                $("#btn-submit").show();
                $(".osahan-desc").html('<div class="text-danger">'+response+'</div>');
            }
        });
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
            $(".osahan-size").html('Size : ' + toSize(file.size));
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
</script>