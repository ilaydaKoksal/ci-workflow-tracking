
<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Giriş</title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/images/favicon.png'); ?>">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
</head>
<body class="h-100">
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <h4>Giriş</h4>
                                <?php if($this->session->flashdata('msg') != ''): ?>
                                    <div class="alert alert-success flash-msg alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4>Başarılı!</h4>
                                        <?php echo $this->session->flashdata('msg'); ?>
                                        <script>
                                            setTimeout(function(){   
                                            window.location="<?php echo base_url('user/register'); ?>";
                                            }, 2000);
                                        </script>
                                    </div>
                                <?php endif; ?>	
                                <?php if($this->session->flashdata('error') != ''): ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4>Hata!</h4>
                                        <?php echo $this->session->flashdata('error'); ?> 
                                    </div>
                                <?php endif; ?>	
                                <?php echo form_open('auth/login', 'class="mt-5 mb-5 login-input"'); ?>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Şifre" required>
                                    </div>
                                    <button class="btn login-form__btn submit w-100">Giriş</button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('assets/plugins/common/common.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/custom.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/settings.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/gleek.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/styleSwitcher.js'); ?>"></script>
</body>
</html>





