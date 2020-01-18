<div class="card">
    <div class="card-body">
        <?php if($this->session->flashdata('msg') != ''): ?>
            <div class="col-md-12 mb-3">
                <div class="alert alert-success flash-msg alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>Başarılı!</h4>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
            </div>
        <?php endif; ?>	
        <?php if($this->session->flashdata('error') != ''): ?>
            <div class="col-md-12 mb-3">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>Hata!</h4>
                    <?php echo $this->session->flashdata('error'); ?> 
                </div>
            </div>
        <?php endif; ?>	
        <?php if(empty($this->uri->segment(2))): ?>
            <div class="float-right">
                <div class="search">
                    <div class="input-group-prepend">
                        <input type="search" name='search_text' id='search_text' data-attribute='record' class="form-control form-search search_text" placeholder="Klinik veya kişi adı ile arayınız.." aria-label="Klinik veya kişi adı giriniz..">
                    </div>
                </div>  
            </div>
        <?php endif; ?>
        <?php if(!empty($get_all)): ?>
            <div class="card-title">
                <h4><?php echo $title; ?></h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style='width: 25%'>Ad Soyad</th>
                            <th style='width: 30%'>Klinik Adı</th>
                            <th style='width: 30%'>Klinik Adresi</th>
                            <?php if( (($this->uri->segment(3) == '') || ($this->uri->segment(3) != '' && $this->session->userdata['user_type'] == 1)) && $this->uri->segment(2) != ''  && !is_numeric($this->uri->segment(2))): ?>
                                <th style='width: 20%'>Görüşen Kişi</th>
                            <?php endif; ?>
                            <?php if($this->uri->segment(3) == '' && $this->uri->segment(2) != '' && !is_numeric($this->uri->segment(2))): ?>
                                <th style='width: 10%'>Aşama</th>
                                <th style='width: 10%'>Durum</th>
                            <?php endif; ?>
                            <?php if($this->uri->segment(3) != ''): ?>
                                <th style='width: 10%'>Durum</th>
                            <?php endif; ?>
                            <th style='width: 10%'>İşlem</th>
                        </tr>
                    </thead>
                    <tbody class="table-result">
                        <?php foreach($get_all as $record): ?>
                        <tr>
                            <td><?php echo $record->record_name_surname; ?></td>
                            <td><?php echo $record->record_clinic_name; ?></td>
                            <td><?php echo $record->record_address; ?></td>
                            <?php if( (($this->uri->segment(3) == '') || ($this->uri->segment(3) != '' && $this->session->userdata['user_type'] == 1)) && $this->uri->segment(2) != ''  && !is_numeric($this->uri->segment(2))): ?>
                                <td><?php echo empty($record->user_name_surname) ? '-' : $record->user_name_surname; ?></td>
                            <?php endif; ?>
                            <?php if($this->uri->segment(3) == '' && $this->uri->segment(2) != '' && !is_numeric($this->uri->segment(2))): ?>
                                <td><span class="badge badge-primary px-2"><?php echo empty($record->stage_name) ? 'Müşteri Kayıt' : $record->stage_name; ?></span></td>
                                <td><span class="badge badge-primary px-2"><?php echo empty($record->status_name) ? 'Müşteri Kaydedildi' : $record->status_name; ?></span></td>
                            <?php endif; ?>
                            <?php if($this->uri->segment(3) != ''): ?>
                                <td><span class="badge badge-primary px-2"><?php echo empty($record->status_name) ? 'Müşteri Kaydedildi' : $record->status_name; ?></span></td>
                            <?php endif; ?>
                            <td>
                            <?php if($this->session->userdata('user_type') == 1 && ($this->uri->segment(2) == '' || is_numeric($this->uri->segment(2)))): ?>
                                <a href="<?php echo base_url('record/delete/'.$record->record_id); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sil"><i class="fas fa-trash-alt mr-2"></i></a>
                            <?php endif; ?>
                            <a href="<?php echo base_url('record/detail/'.$record->record_id); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Detaylar"><i class="fas fa-qrcode"></i></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="bootstrap-pagination">
                <nav>
                    <ul class="pagination pagination-sm">
                        <?php echo $links; ?>
                    </ul>
                </nav>
            </div>
        <?php else: ?>
            <p>Kayıt bulunamadı!</p>
        <?php endif; ?>
    </div>
</div>
