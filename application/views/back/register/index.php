<div class="card">
    <div class="card-body">
        <?php if(!empty($get_all)): ?>
            <div class="card-title">
                <h4><?php echo $title; ?></h4>
            </div>
            <?php if($this->session->flashdata('msg') != ''): ?>
                <div class="alert alert-success flash-msg alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>Başarılı!</h4>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
            <?php endif; ?>	
            <?php if($this->session->flashdata('error') != ''): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>Hata!</h4>
                    <?php echo $this->session->flashdata('error'); ?> 
                </div>
            <?php endif; ?>	
            <?php if(empty($this->uri->segment(3)) || empty($this->uri->segment(4))): ?>
                <div class="float-right" >
                    <div class="search">
                        <div class="input-group-prepend">
                            <input type="search" name='search_text' id='search_text' data-attribute='register' class="form-control form-search search_text" placeholder="Klinik veya kişi adı ile arayınız.." aria-label="Klinik veya kişi adı giriniz..">
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style='width: 30%'>Ad Soyad</th>
                            <th style='width: 30%'>Telefon</th>
                            <th style='width: 30%'>Email</th>
                            <th style='width: 10%'>İşlem</th>
                        </tr>
                    </thead>
                    <tbody class="table-result">
                        <?php foreach($get_all as $user): ?>
                        <tr>
                            <td><?php echo $user->user_name_surname; ?></td>
                            <td><?php echo $user->user_phone; ?></td>
                            <td><?php echo $user->user_email; ?></td>
                            <td>
                                <a href="<?php echo base_url('admin/member_delete/'.$user->user_id); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sil"><i class="fas fa-trash-alt mr-2"></i></a>
                                <a href="<?php echo base_url('admin/detail/'.$user->user_id); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Detaylar"><i class="fas fa-qrcode mr-2"></i></a>
                                <a href="<?php echo base_url('transfer/index/'.$user->user_id); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Kayıt Aktar"><i class="fas fa-exchange-alt"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="bootstrap-pagination">
                    <nav>
                        <ul class="pagination pagination-sm">
                            <?php echo $links; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php else: ?>
            <p>Kayıt bulunamadı!</p>
        <?php endif; ?>
    </div>
</div>
