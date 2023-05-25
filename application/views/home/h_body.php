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
        <title><?php echo element('title', $meta, $meta_title_default).' | '.$app['judul']; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Copyright" content="<?php echo element('author', $meta, $meta_author_default); ?>" />
        
        <!-- Mobile on Android -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="theme-color" content="<?= $theme[10] ?>" />
        <meta name="application-name" content="<?php echo element('title', $meta, $meta_title_default).' | '.$app['judul']; ?>">
        <meta name="msapplication-navbutton-color" content="<?= $theme[10] ?>">   
        <!-- Mobile on iOS -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="<?= $theme[10] ?>">
        <meta name="apple-mobile-web-app-title" content="<?php echo element('title', $meta, $meta_title_default).' | '.$app['judul']; ?>">   
        
        <link rel="shortcut icon" type="image/x-icon" href="<?= load_file('app/img/logo.png') ?>"/>  
        <link rel="manifest" href="<?= base_url('manifest.json') ?>">
        <link rel="canonical" href="<?php echo element('url', $meta, $meta_url_default); ?>">
        <link rel="amphtml" href="<?php echo element('amp_url', $meta, $meta_url_default); ?>">
        
        <!-- SEARCH ENGINE -->
        <meta name="keywords" content="<?php echo element('title', $meta, $meta_title_default).' | '.$app['judul']; ?>" />
        <meta name="description" content="<?php echo limit_text(element('description', $meta, $meta_desc_default),200); ?>">
        <meta name="author" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <meta name="rating" content="general">
        
        <meta itemprop="name" content="<?php echo element('title', $meta, $meta_title_default).' | '.$app['judul']; ?>" />
        <meta itemprop="description" content="<?php echo limit_text(element('description', $meta, $meta_desc_default),200); ?>" />
        <meta itemprop="image" content="<?php echo element('thumbnail', $meta, $meta_img_default); ?>" />

        <!-- FACEBOOK META -  Change what to your own FB-->
        <meta property="fb:app_id" content="MY_FB_ID">
        <meta property="fb:pages" content="MY_FB_FAGE_ID" />
        <meta property="og:title" content="<?php echo element('title', $meta, $meta_title_default).' | '.$app['judul']; ?>">
        <meta property="og:type" content="article">
        <meta property="og:url" content="<?php echo element('url', $meta, $meta_url_default); ?>">
        <meta property="og:site_name" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <meta property="og:image" content="<?php echo element('thumbnail', $meta, $meta_img_default); ?>" >
        <meta property="og:description" content="<?php echo limit_text(element('description', $meta, $meta_desc_default),200); ?>">
        
        <meta property="article:publisher" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <meta property="article:author" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <meta property="article:tag" content="<?php echo element('title', $meta, $meta_title_default).' | '.$app['judul']; ?>">

        <!-- TWITTER META - Change what to your own twitter-->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:description" content="<?php echo limit_text(element('description', $meta, $meta_desc_default),200); ?>">
        <meta name="twitter:site" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <meta name="twitter:creator" content="@my_twitter">
        <meta name="twitter:title" content="<?php echo element('title', $meta, $meta_title_default).' | '.$app['judul']; ?>">
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
        load_js(array(
            "frontend/vidoe/vendor/jquery/jquery.min.js",
        ));
        ?>
    </head>
    <!-- BEGIN body -->
    <body>
        
        <?php $this->load->view('home/h_header'); ?>
        
        <div id="wrapper">

            <ul class="sidebar navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= site_url() ?>">
                        <i class="fas fa-fw fa-home"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('channel') ?>">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Channels</span>
                    </a>
                </li>
                <li class="nav-item channel-sidebar-list"></li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('video/riwayat') ?>">
                        <i class="fas fa-fw fa-history"></i>
                        <span>Riwayat</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('video/topik') ?>">
                        <i class="fas fa-fw fa-list-alt"></i>
                        <span>Topik</span>
                    </a>
                </li>
                <li class="nav-item channel-sidebar-list">
                    <h6>SUBSCRIPTIONS</h6>
                    <ul>
                        <li>
                            <a href="subscriptions.html">
                                <img class="img-fluid" alt src="<?= base_url() ?>/app/frontend/vidoe/img/s1.png"> Your Life
                            </a>
                        </li>
                        </li>
                    </ul>
                </li>
            </ul>
            
            <div id="content-wrapper">
               
                <?= $content ?>
                
                <?php $this->load->view('home/h_footer'); ?>
                
            </div>

        </div>
        
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        
        <?php
        load_js(array(
            "frontend/vidoe/vendor/bootstrap/js/bootstrap.bundle.min.js",
            "frontend/vidoe/vendor/jquery-easing/jquery.easing.min.js",
            "frontend/vidoe/vendor/owl-carousel/owl.carousel.js",
            "frontend/vidoe/js/custom.js",
            "frontend/vidoe/js/rocket-loader.min.js"
        ));
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/UpUp/1.0.0/upup.min.js"></script>
        <script async type="text/javascript">
            $(document).ready(function() {
                $("body").on("contextmenu", function (e) {
                    //return false;
                });
                const filesToCache = [
                    "app/backend/puru.css",
                    "app/backend/assets/fonts/poppins/font.css?family=Poppins:300,400,500,600,700",
                    
                    "app/frontend/edu/css/reset.css",
                    "app/frontend/edu/css/main-stylesheet.css",
                    "app/frontend/edu/css/shortcode.css",
                    "app/frontend/edu/css/fonts.css",
                    "app/frontend/edu/css/colors.css",
                    "app/frontend/edu/css/responsive.css",
                    "app/frontend/edu/css/ppg.css",
                    "app/backend/assets/js/lazy/lazysizes.min.js",
                    "app/frontend/edu/jscript/jquery-latest.min.js",
                    "app/frontend/edu/jscript/theme-scripts.js"
                ];
//                UpUp.start({
//                    'cache-version': '<?= SW_VERSION ?>',
//                    'content-url': '<?= site_url() ?>',
//                    'content': 'No Internet Connection',
//                    'service-worker-url': "<?= base_url('sw.js') ?>",
//                    'assets': filesToCache
//                });
            });
        </script>
    </body>
</html>
