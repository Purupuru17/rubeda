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
                <div class="app">
                    <a href="#"><img alt src="<?= load_file($app['logo'], 1) ?>"></a>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>