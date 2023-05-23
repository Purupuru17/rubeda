<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="login-container">
            <div class="space-6"></div>
            <div class="center">
                <a class="no-hover" href="<?= site_url() ?>">
                    <img class="blur-up lazyload width-40" src="<?= load_file($app['logo']) ?>" />
                </a>
            </div>
            <div class="space-6"></div>
            <div class="position-relative">
                <div id="login-box" class="login-box visible widget-box no-border">
                    <div class="widget-body">
                        <div class="widget-main">
                            <h4 align="center" class="header blue lighter bigger">
                                <i class="ace-icon fa fa-home blue bigger-110"></i>
                                Halaman Login
                            </h4>
                            <?= $this->session->flashdata('notif'); ?>
                            <div class="space-6"></div>
                            <form id="validation-form" name="form" method="POST" action="<?= site_url($action.'/auth'); ?>" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="form-group">
                                        <div class="block clearfix">
                                            <div class="input-group">
                                                <input type="text" id="username" name="username" class="form-control" placeholder="Username" />
                                                <span class="input-group-addon">
                                                    <i class="ace-icon fa fa-user"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="block clearfix">
                                            <div class="input-group">
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" />
                                                <span id="gshow" class="input-group-addon">
                                                    <i class="ace-icon red fa fa-eye-slash"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="block clearfix">
                                            <?php echo $captcha ?>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <button type="submit" class="width-100 btn btn-primary btn-bold btn-white">
                                            <i class="ace-icon fa fa-key"></i>
                                            <span class="bigger-110">Masuk</span>
                                        </button>
                                    </div>
                                    <div class="space-4"></div>
                                </fieldset>
                            </form>
                            <div class="social-or-login center">
                                <span class="blue" id="id-company-text">Copyright © 2022 <?= $app['judul'] ?></span>
                            </div>
                            <div class="space-6"></div>
                        </div><!-- /.widget-main -->

                        <div class="toolbar clearfix">
                            <div class="center">
                                <a href="#" data-target="#forgot-box" class="hide forgot-password-link">
                                    <i class="ace-icon fa fa-arrow-left"></i>
                                    Lupa Password ?
                                </a>
                            </div>
                        </div>
                    </div><!-- /.widget-body -->
                </div><!-- /.login-box -->
                <div id="forgot-box" class="forgot-box widget-box no-border">
                    <div class="widget-body">
                        <div class="widget-main">
                            <h4 align="center" class="header red lighter bigger">
                                <i class="ace-icon fa fa-key"></i>
                                Memulihkan Password
                            </h4>
                            <div class="space-6"></div>
                            <p>Masukkan email yang telah terdaftar pada aplikasi. Password baru akan dikirim melalui email anda.</p>
                            <form id="validation-forgot" name="form-forgot" method="POST" action="<?= site_url($action.'/forgot'); ?>">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="block clearfix">
                                            <span class="block input-icon input-icon-right">
                                                <input type="email" name="femail" id="femail" class="form-control" placeholder="Email Anda" />
                                                <i class="ace-icon fa fa-envelope"></i>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="clearfix">
                                        <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                            <i class="ace-icon fa fa-send"></i>
                                            <span class="bigger-110">Kirim</span>
                                        </button>
                                    </div>
                                </fieldset>
                            </form>
                        </div><!-- /.widget-main -->

                        <div class="toolbar center">
                            <a href="#" data-target="#login-box" class="back-to-login-link">
                                Kembali
                                <i class="ace-icon fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div><!-- /.widget-body -->
                </div><!-- /.forgot-box -->
            </div>
        </div>
    </div><!-- /.col -->
</div><!-- /.row -->
<?= $script_captcha ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#username').focus();
    });
    $(document).on('click', 'a[data-target]', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.widget-box.visible').removeClass('visible');//hide others
        $(target).addClass('visible');//show target
    });
    $("#gshow").on("click", function(e) {
        var pass = $("#password");
        if(pass.attr('type') === 'password') {
            pass.attr('type','text');
            $("#gshow > i").removeClass('red fa-eye-slash').addClass('blue fa-eye');
        }else{
            pass.attr('type','password');
            $("#gshow > i").removeClass('blue fa-eye').addClass('red fa-eye-slash');
        }
    });
    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            username: {
                required: true,
                minlength: 5
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        highlight: function(e) {
            $(e).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(e) {
            $(e).closest('.form-group').removeClass('has-error').addClass('has-success');
            $(e).remove();
        },
        errorPlacement: function(error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if (controls.find(':checkbox,:radio').length > 1)
                    controls.append(error);
                else
                    error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if (element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if (element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else
                error.insertAfter(element.parent());
        },
        invalidHandler: function(form) {
        }
    });
    $('#validation-forgot').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            femail: {
                required: true,
                email: true,
                minlength: 5
            }
        },
        highlight: function(e) {
            $(e).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(e) {
            $(e).closest('.form-group').removeClass('has-error').addClass('has-success');
            $(e).remove();
        },
        errorPlacement: function(error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if (controls.find(':checkbox,:radio').length > 1)
                    controls.append(error);
                else
                    error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if (element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if (element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else
                error.insertAfter(element.parent());
        },
        invalidHandler: function(form) {
        }
    });
</script>
