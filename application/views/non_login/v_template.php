<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $param = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
            $meta = isset($meta) ? $meta : [];
            $meta_title_default = $app['judul'] .' | '.ctk($app['deskripsi']);
            $meta_desc_default = ctk($app['deskripsi']);
            $meta_author_default = $app['judul'];
            $meta_url_default  = current_url() . $param;
            $meta_img_default  = base_url($app['logo']);    
        ?>
        <!-- Basic page needs ============================================ -->
        <title><?= element('title', $meta, $meta_title_default); ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <!-- SEARCH ENGINE -->
        <meta name="keywords" content="<?php echo ctk(element('title', $meta, $meta_title_default)); ?>" />
        <meta name="description" content='<?php echo ctk(element('description', $meta, $meta_desc_default)); ?>'>
        <meta name="author" content="<?php echo element('author', $meta, $meta_author_default); ?>">
        <link rel="canonical" href="<?php echo element('url', $meta, $meta_url_default); ?>">
        <link rel="amphtml" href="<?php echo element('amp_url', $meta); ?>">
        <meta name="rating" content="general">
        
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?= load_file('app/img/logo.png') ?>">
        
        <?php
        load_css(array(
            'backend/assets/css/bootstrap.css',
            'backend/assets/css/font-awesome.css',
            'backend/assets/css/ace-fonts.css',
            'backend/assets/css/ace-rtl.css',
            'backend/puru.css',
            'backend/assets/css/jquery.gritter.css',
        ));
        load_js(array(
            'backend/assets/js/ace-extra.js',
            'backend/assets/js/jquery.js',
            'backend/assets/js/bootstrap.js',
            'backend/assets/js/jquery.validate.js',
            'backend/assets/js/ace/elements.fileinput.js',
            'backend/assets/js/ace/ace.js',
            'backend/assets/js/jquery.gritter.js',
            'backend/assets/js/lazy/lazysizes.min.js',
        ));
        ?>
        <!-- ace styles -->
        <link rel="stylesheet" href="<?= base_url('app/backend/assets/css/ace.css') ?>" class="ace-main-stylesheet" id="main-ace-style" />

    </head>

    <body class="login-layout">
        <div class="main-container">
            <div class="main-content">
                <?= $content ?>
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->
        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='<?= base_url('app/backend/assets/js/jquery.mobile.custom.js') ?>'>" + "<" + "/script>");
            
            $(document).ready(function() {
                var login = "<?= $theme[1] ?>";
                if (login === "1") {
                    $('body').attr('class', 'login-layout');
                    $('#id-text2').attr('class', 'white');
                    $('#id-company-text').attr('class', 'blue');
                } else if (login === "2") {
                    $('body').attr('class', 'login-layout blur-login');
                    $('#id-text2').attr('class', 'white');
                    $('#id-company-text').attr('class', 'light-blue');
                } else {
                    $('body').attr('class', 'login-layout light-login');
                    $('#id-text2').attr('class', 'red');
                    $('#id-company-text').attr('class', 'blue');
                }
            });
        </script>
    </body>
</html>
