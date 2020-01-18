<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Hata</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
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
                    <div class="error-content">
                        <div class="card mb-0">
                            <div class="card-body text-center">
                                <h3 class="error-text text-primary">HATA</h3>
                                <p> </p>
                                <p>Açık olan bir oturum var.</p>
                                <p>Diğer oturumu kapatmadan yeni bir oturum açılamaz!</p>
                                <form class="mt-5 mb-5">
                                    
                                    <div class="text-center mb-4 mt-4"><a href="<?php echo $this->session->userdata['user_type'] == 1 ? base_url('admin') : base_url('user'); ?>" class="btn btn-primary">Anasayfaya Git</a>
                                    </div>
                                </form>
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





