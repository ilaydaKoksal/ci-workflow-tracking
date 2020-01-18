<?php if($this->session->has_userdata('user_type')){ ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title><?php echo $title; ?></title>
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/images/favicon.png'); ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="<?php echo base_url('assets/plugins/pg-calendar/css/pignose.calendar.min.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/chartist/css/chartist.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css'); ?>">
        <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/icons/font-awesome/css/all.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/icons/font-awesome/css/brands.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/icons/font-awesome/css/solid.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/clockpicker/dist/jquery-clockpicker.min.css'); ?>" rel="stylesheet">
    </head>
    <body>
        <div id="preloader">
            <div class="loader">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
                </svg>
            </div>
        </div>
        <div id="main-wrapper">
            <div class="nav-header">
                <div class="brand-logo">
                    <a href="<?php 
                    if($this->session->userdata('user_type') == 1){
                        echo base_url('admin'); 
                    } else {
                        echo base_url('user'); 
                    }
                    ?>">
                        <b class="logo-abbr"><img src="images/logo.png'); ?>" alt=""> </b>
                        <span class="logo-compact"><img src="<?php echo base_url('assets/images/logo-compact.png'); ?>" alt=""></span>
                        <span class="brand-title">
                            <img src="<?php echo base_url('assets/images/logo-text.png'); ?>" alt="">
                        </span>
                    </a>
                </div>
            </div>
            <div class="header">    
                <div class="header-content clearfix">
                    <div class="header-left col-md-6">
                        <div class="input-group icons">
                            <input type="search" name='search_text' id='search_text' class="form-control search_text" placeholder="Klinik veya kişi adı giriniz.." aria-label="Klinik veya kişi adı giriniz..">
                            <div class="result d-none"></div>
                        </div>
                    </div>
                    <div class="header-right">
                        <ul class="clearfix">
                            <li class="icons border-right px-4">
                                <a href="<?php echo base_url('profile'); ?>"><i class="icon-user"></i> <span>Hoşgeldin, <b><?php echo $this->session->userdata('user_name_surname'); ?></b></span></a>
                            </li>
                            <li class="icons pl-4">
                                <a href="<?php echo base_url('auth/logout'); ?>"><i class="icon-key"></i> <span>Çıkış</span>
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="nk-sidebar">           
                <div class="nk-nav-scroll">
                    <ul class="metismenu" id="menu">
                        <li class="nav-label"></li>
                        <li class="mega-menu mega-menu-sm">
                            <a class="" href="<?php echo $this->session->userdata('user_type') == 1 ? base_url('admin') : base_url('user'); ?>" aria-expanded="false">
                            <i class="fas fa-campground"></i><span class="nav-text">Anasayfa</span>
                            </a>
                        </li>
                        
                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="fas fa-layer-group"></i><span class="nav-text">Aşamalar</span>
                            </a>
                            <ul aria-expanded="false">
                                <?php if($this->session->userdata['user_type'] == 2): ?>
                                    <li><a href="<?php echo base_url('record/user_index'); ?>"><i class="far fa-list-alt"></i> Müşteri Seç</a></li>
                                <?php endif; ?>
                                <?php 
                                    foreach($get_stage as $stage):
                                ?>
                                    <li><a href="<?php echo base_url('record/all_record/'.$stage->stage_id); ?>"><i class="fas fa-angle-double-right"></i><?php echo $stage->stage_name; ?></a></li>
                                <?php endforeach; ?>
                                <li><a href="<?php echo base_url('record/all_record'); ?>"><i class="fab fa-google-wallet"></i>Tüm Hareketler</a></li>
                                <?php if($this->session->userdata('user_type') == 2): ?>
                                    <li><a href="<?php echo base_url('transfer'); ?>"><i class="fas fa-exchange-alt"></i>Kayıtlarımı Aktar</a></li>
                                <?php endif; ?>
                                <li class="nav-item"><a class="nav-link d-none" href="<?php echo ($this->uri->segment(2) == "all_record") ? base_url($this->uri->uri_string()) : "#"; ?>"></a></li>
                            </ul>
                        </li>
                        <?php if($this->session->userdata['user_type'] == 1): ?>
                        <li class="mega-menu mega-menu-sm">
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="fas fa-street-view"></i><span class="nav-text">Üye İşlemleri</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="<?php echo base_url('admin/member'); ?>"><i class="far fa-plus-square"></i> Üye Ekle</a></li>
                                <li><a href="<?php echo base_url('admin/all_member'); ?>"><i class="far fa-list-alt"></i> Tüm Üyeler</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <li class="mega-menu mega-menu-sm">
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fas fa-user-friends"></i><span class="nav-text">Müşteri İşlemleri</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="<?php echo base_url('record/add'); ?>"><i class="far fa-plus-square"></i> Müşteri Ekle</a></li>
                                <li><a href="<?php echo base_url('record'); ?>"><i class="far fa-list-alt"></i> Tüm Müşteriler</a></li>
                                <li class="nav-item"><a class="nav-link d-none" href="<?php echo ($this->uri->segment(2) == "record/add") ? base_url($this->uri->uri_string()) : "#"; ?>"></a></li>
                                <li class="nav-item"><a class="nav-link d-none" href="<?php echo ($this->uri->segment(2) == "" && $this->uri->segment(1) == 'record') ? base_url($this->uri->uri_string()) : "#"; ?>"></a></li>
                            </ul>
                        </li>
                        <?php if($this->session->userdata['user_type'] == 1): ?>
                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="fas fa-cash-register"></i><span class="nav-text">Aşama/Durum İşlemleri</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="<?php echo base_url('stage_status'); ?>"><i class="far fa-plus-square"></i> Aşama/Durum Ekle</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if($this->session->userdata['user_type'] == 1): ?>
                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="fas fa-bullhorn"></i><span class="nav-text">Duyuru İşlemleri</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="<?php echo base_url('announcement/announcement'); ?>"><i class="far fa-plus-square"></i> Duyuru Oluştur</a></li>
                                <li><a href="<?php echo base_url('announcement'); ?>"><i class="far fa-list-alt"></i> Tüm Duyurular</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="content-body">
                <div class="container-fluid mt-3">
                    <?php $this->load->view($view); ?>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('assets/plugins/common/common.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/custom.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/settings.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/gleek.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/styleSwitcher.js'); ?>"></script>

        <script src="<?php echo base_url('assets/plugins/chart.js/Chart.bundle.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/circle-progress/circle-progress.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/d3v3/index.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/topojson/topojson.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datamaps/datamaps.world.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/raphael/raphael.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/morris/morris.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/moment/moment.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/pg-calendar/js/pignose.calendar.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/chartist/js/chartist.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/dashboard/dashboard-1.js'); ?>"></script>
        
        <script src="<?php echo base_url('assets/plugins/moment/moment.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-material-datetimepicker/js/lang.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/clockpicker/dist/jquery-clockpicker.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/plugins-init/form-pickers-init.js'); ?>"></script>
        <script>
            //search operation
            $(document).ready(function(){
                $('.search_text').keyup(function(){
                    var search = $(this).val();
                    var attribute = $(this).data('attribute');
                    if(attribute == 'register' || attribute == 'record'){
                        load_other(search, attribute);
                    } else {
                        load_data(search);
                    }
                });
                function load_data(query){
                    if(query.length < 1){
                        query = 0
                    }
                    $.ajax({
                        url:"<?php echo base_url(); ?>search/fetch",
                        method:"POST",
                        dataType: "JSON",
                        data:{query:query},
                        success:function(data){
                            $('.result').removeClass('d-none');
                            $('.result').html('');
                            if(data.success){
                                $.each(data.success, function(key, value) { 
                                    $('.result').append('<a href="<?php echo base_url('record/detail/'); ?>'+value.record_id+'" class="d-block">'+value.record_name_surname+' - '+value.record_clinic_name+'</a>');
                                });
                            } else {
                                $('.result').addClass('d-none');
                            }
                        }
                    });
                }
                function load_other(query, key = null){
                    if(query.length < 1){
                        query = 0;
                    }
                    $.ajax({
                        url:"<?php echo base_url(); ?>search/fetch",
                        method:"POST",
                        dataType: "JSON",
                        data:{query:query, key:key},
                        success:function(data){
                            $('.table-result').removeClass('d-none');
                            $('.table-result').html('');
                            if(data.success){
                                if(key == 'record'){
                                    $.each(data.success, function(key, value) { 
                                        $('.table-result').append(
                                            '<tr>'+
                                            '<td>'+value.record_name_surname+'</td>'+
                                            '<td>'+value.record_clinic_name+'</td>'+
                                            '<td>'+value.record_address+'</td>'+
                                            '<td><a href="<?php echo base_url('record/detail/'); ?>'+value.record_id+'"><i class="fas fa-qrcode mr-2"></i></a>'+
                                            <?php if($this->session->userdata('user_type') == 1){ ?>
                                                '<a href="<?php echo base_url('record/delete/'); ?>'+value.record_id+'"><i class="fas fa-trash-alt"></i></a>'+
                                            <?php } ?>
                                            '</td>'+
                                        '</tr>'
                                        );
                                    });
                                } else if(key == 'register'){
                                    $.each(data.success, function(key, value) { 
                                        $('.table-result').append(
                                            '<tr>'+
                                            '<td>'+value.user_name_surname+'</td>'+
                                            '<td>'+value.user_phone+'</td>'+
                                            '<td>'+value.user_email+'</td>'+
                                            '<td><a href="<?php echo base_url('admin/detail/'); ?>'+value.user_id+'"><i class="fas fa-qrcode mr-2"></i></a>'+
                                            <?php if($this->session->userdata('user_type') == 1){ ?>
                                                '<a href="<?php echo base_url('admin/member_delete/'); ?>'+value.user_id+'"><i class="fas fa-trash-alt mr-2"></i></a>'+
                                                '<a href="<?php echo base_url('transfer/index/'); ?>'+value.user_id+'"><i class="fas fa-exchange-alt"></i></a>'+
                                            <?php } ?>
                                            '</td>'+
                                        '</tr>'
                                        );
                                    });
                                }
                            } else {
                                $('.table-result').addClass('d-none');
                            }
                        }
                    });
                }
            });
        </script>
    </body>
    </html>
<?php } else{ redirect('auth'); } ?>