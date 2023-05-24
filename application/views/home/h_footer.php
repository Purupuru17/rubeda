<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<footer class="sticky-footer">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-6 col-sm-6">
                <p class="mt-1 mb-0">&copy; Copyright 2023 <strong class="text-dark"><?= $app['judul'] ?></strong>. <br>
                    <small class="mt-0 mb-0"><small>{elapsed_time} detik ~ {memory_usage}</small> by <a class="text-primary" target="_blank" href="#">UNIMUDA Sorong</a>
                    </small>
                </p>
            </div>
            <div class="col-lg-6 col-sm-6 text-right">
                <div class="">
                    <a href="<?= site_url() ?>"><img src="<?= load_file($app['logo'], 1) ?>" style="height: 50px;"></a>
                </div>
            </div>
        </div>
    </div>
</footer>