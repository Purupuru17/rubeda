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
                        <p class="mb-0"><i class="fas fa-eye"></i> ? views</p>
                    </div>
                    <div class="single-video-author box mb-3">
                        <div class="float-right">
                            <button class="btn btn-danger" type="button">Subscribe <strong>1.4M</strong></button> 
                            <button class="btn btn btn-outline-danger" type="button"><i class="fa fa-thumbs-up"></i></button>
                        </div>
                        <img class="img-fluid" src="<?= load_file($detail['img_creator']) ?>" alt>
                        <p><a href="<?= site_url('channel/'.$detail['slug_creator']) ?>"><strong><?= $detail['nama_creator'] ?></strong></a> 
                            <span title data-placement="top" data-toggle="tooltip" data-original-title="Verified">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                        </p>
                        <small>Upload pada <?= selisih_wkt($detail['create_video']) ?></small>
                    </div>
                    <div class="single-video-info-content box mb-3">
                        <h6>Privasi :</h6>
                        <p><?= ($detail['privasi_video'] == '1' ? 'Public' : 'Private') ?></p>
                        
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
                        <div class="col-md-12">
                            <div class="main-title">
                                <div class="btn-group float-right right-action">
                                    <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                    </div>
                                </div>
                                <h6>Video Lainnya</h6>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="video-card video-card-list">
                                <div class="video-card-image">
                                    <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                    <a href="#"><img class="img-fluid" src="img/v1.png" alt></a>
                                    <div class="time">3:50</div>
                                </div>
                                <div class="video-card-body">
                                    <div class="btn-group float-right right-action">
                                        <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                        </div>
                                    </div>
                                    <div class="video-title">
                                        <a href="#">Here are many variati of passages of Lorem</a>
                                    </div>
                                    <div class="video-page text-success">
                                        Education <a title data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                    </div>
                                    <div class="video-view">
                                        1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>