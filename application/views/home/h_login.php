<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Basic page needs ============================================ -->
        <?php
        $param = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
        $meta = isset($meta) ? $meta : [];
        $meta_title_default = $app['deskripsi'];
        $meta_desc_default = $app['deskripsi'];
        $meta_author_default = $app['cipta'];
        $meta_url_default = current_url() . $param;
        $meta_img_default = base_url($app['logo']);
        ?>
        <title><?php echo element('title', $meta, $meta_title_default) . ' | ' . $app['judul']; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Copyright" content="<?php echo element('author', $meta, $meta_author_default); ?>" />

        <!-- Mobile on Android -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="theme-color" content="<?= $theme[10] ?>" />
        <meta name="application-name" content="<?php echo element('title', $meta, $meta_title_default) . ' | ' . $app['judul']; ?>">
        <meta name="msapplication-navbutton-color" content="<?= $theme[10] ?>">   
        <!-- Mobile on iOS -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="<?= $theme[10] ?>">
        <meta name="apple-mobile-web-app-title" content="<?php echo element('title', $meta, $meta_title_default) . ' | ' . $app['judul']; ?>">   

        <link rel="icon" type="image/png"  href="<?= load_file('app/img/logo.png') ?>"/>
        <link rel="manifest" href="<?= base_url('manifest.json') ?>">
        <link rel="canonical" href="<?php echo element('url', $meta, $meta_url_default); ?>">
        <link rel="amphtml" href="<?php echo element('amp_url', $meta, $meta_url_default); ?>">

        <!-- SEARCH ENGINE -->
        <meta name="keywords" content="<?php echo element('title', $meta, $meta_title_default) . ' | ' . $app['judul']; ?>" />
        <meta name="description" content="<?php echo limit_text(element('description', $meta, $meta_desc_default), 200); ?>">
        <meta name="author" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <meta name="rating" content="general">

        <meta itemprop="name" content="<?php echo element('title', $meta, $meta_title_default) . ' | ' . $app['judul']; ?>" />
        <meta itemprop="description" content="<?php echo limit_text(element('description', $meta, $meta_desc_default), 200); ?>" />
        <meta itemprop="image" content="<?php echo element('thumbnail', $meta, $meta_img_default); ?>" />

        <!-- FACEBOOK META -  Change what to your own FB-->
        <meta property="fb:app_id" content="MY_FB_ID">
        <meta property="fb:pages" content="MY_FB_FAGE_ID" />
        <meta property="og:title" content="<?php echo element('title', $meta, $meta_title_default) . ' | ' . $app['judul']; ?>">
        <meta property="og:type" content="article">
        <meta property="og:url" content="<?php echo element('url', $meta, $meta_url_default); ?>">
        <meta property="og:site_name" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <meta property="og:image" content="<?php echo element('thumbnail', $meta, $meta_img_default); ?>" >
        <meta property="og:description" content="<?php echo limit_text(element('description', $meta, $meta_desc_default), 200); ?>">

        <meta property="article:publisher" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <meta property="article:author" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <meta property="article:tag" content="<?php echo element('title', $meta, $meta_title_default) . ' | ' . $app['judul']; ?>">

        <!-- TWITTER META - Change what to your own twitter-->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:description" content="<?php echo limit_text(element('description', $meta, $meta_desc_default), 200); ?>">
        <meta name="twitter:site" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <meta name="twitter:creator" content="@my_twitter">
        <meta name="twitter:title" content="<?php echo element('title', $meta, $meta_title_default) . ' | ' . $app['judul']; ?>">
        <meta name="twitter:image:src" content="<?php echo element('thumbnail', $meta, $meta_img_default); ?>"> 
        <meta name="twitter:domain" content="<?php echo element('url', $meta, $meta_url_default); ?>" />

        <?php
        load_css(array(
            "frontend/vidoe/vendor/bootstrap/css/bootstrap.min.css",
            "frontend/vidoe/vendor/fontawesome-free/css/all.min.css",
            "frontend/vidoe/css/osahan.css",
            "frontend/vidoe/vendor/owl-carousel/owl.carousel.css",
            "frontend/vidoe/vendor/owl-carousel/owl.theme.css"
        ));
        ?>
        <?php
        load_js(array(
            "frontend/vidoe/vendor/jquery/jquery.min.js",
        ));
        ?>
    </head>
    <body class="login-main-body">
        <section class="login-main-wrapper">
            <div class="container-fluid pl-0 pr-0">
                <div class="row no-gutters">
                    <div class="col-md-5 p-5 bg-white full-height">
                        <div class="login-main-left">
                            <div class="text-center mb-5 login-main-left-header pt-4">
                                <img width="240" src="<?= base_url($app['logo']) ?>" class="img-fluid" alt="<?= $app['judul'] ?>">
                                <h5 class="mt-3 mb-3"><?= $app['deskripsi'] ?></h5>
                            </div>
                            <?= $this->session->flashdata('notif'); ?>
                            <form id="validation-form" name="form" method="POST" action="<?= site_url($module.'/auth'); ?>" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Nomor Telepon</label>
                                    <input required="" name="username" type="text" class="form-control" placeholder="Masukkan Nomor Telepon">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input required="" name="password" type="password" class="form-control" placeholder="Masukkan Password">
                                </div>
                                <div class="mt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-outline-primary btn-block btn-lg">Masuk</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="text-center mt-5">
                                <p class="light-gray">Belum memiliki akun ? <a href="<?= site_url($module.'/daftar') ?>">Daftar</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="login-main-right bg-white p-5 mt-5 mb-5">
                            <div class="owl-carousel owl-carousel-login">
                                <div class="item">
                                    <div class="carousel-login-card text-center">
                                        <img src="img/login.png" class="img-fluid" alt="LOGO">
                                        <h5 class="mt-5 mb-3">​Watch videos offline</h5>
                                        <p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="carousel-login-card text-center">
                                        <img src="img/login.png" class="img-fluid" alt="LOGO">
                                        <h5 class="mt-5 mb-3">Download videos effortlessly</h5>
                                        <p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="carousel-login-card text-center">
                                        <img src="img/login.png" class="img-fluid" alt="LOGO">
                                        <h5 class="mt-5 mb-3">Create GIFs</h5>
                                        <p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
        load_js(array(
            "frontend/vidoe/vendor/bootstrap/js/bootstrap.bundle.min.js",
            "frontend/vidoe/vendor/jquery-easing/jquery.easing.min.js",
            "frontend/vidoe/vendor/owl-carousel/owl.carousel.js",
            "frontend/vidoe/js/custom.js",
            "frontend/vidoe/js/rocket-loader.min.js"
        ));
        ?>
    </body>
</html>