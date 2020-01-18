<?php if(!empty($get_record)): ?>
    <div class="row">
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
        <div class="col-md-7">  
            <div class="row">
                <?php if($get_record->record_user_id == $this->session->userdata('user_id') || $get_record->record_user_id == 0 && $this->session->userdata('user_type') == 2): ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="mb-3 float-left">Notlar</h4>
                                </div>
                                <div class="col-md-8">
                                    <div class="bootstrap-label">
                                        <span class="label label-secondary m-1"><?php echo !empty($get_record->status_name) ? $get_record->status_name : 'Müşteri Kaydedildi'; ?></span>
                                        <span class="label label-primary m-1"><?php echo !empty($get_record->stage_name) ? $get_record->stage_name : 'Müşteri Kayıt'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <?php echo form_open('record/add_note/'.$get_record->record_id); ?>
                                <div class="basic-form">
                                    <div class="form-group">
                                        <label>Aşama</label>
                                        <select name="stage" class="form-control">
                                            <option selected value="0">Aşama Seçiniz.</option>
                                            <?php foreach($get_stage as $stage): ?>
                                                <option value="<?php echo $stage->stage_id; ?>">
                                                    <?php echo $stage->stage_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div> 
                                    <div class="form-group">
                                        <label>Durum</label>
                                        <select name="status" class="form-control">
                                            <option selected value="0">Durum Seçiniz.</option>
                                            <?php foreach($get_status as $status): ?>
                                                <option value="<?php echo $status->status_id; ?>">
                                                    <?php echo $status->status_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="m-t-40">Tarih / Saat</label>
                                        <label class="alert-danger float-right note p-1"><i class="fas fa-exclamation"></i>  Notun hatırlatılmasını istiyorsanız lütfen tarih / saat seçiniz!</label>
                                        <input type="text" name="datetime" class="form-control" placeholder="Tarih / Saat Seçiniz" id="min-date">
                                    </div>
                                    <div class="form-group">
                                        <label>Not Yaz</label>
                                        <textarea class="form-control" name="note" rows="5" value="<?php echo !empty($get_record->record_address) ? $get_record->record_address : ''; ?>"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">Yorum Ekle</button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(!empty($get_notes)): ?>
                    <div class="col-md-12">
                    <h4 class="mb-3">Notlar</h4>
                        <?php foreach($get_notes as $note): ?>
                        <?php 
                            $post_date = strtotime($note->note_created_at);
                            $now = time();
                        ?>
                        <div class="media media-reply bg-white">
                            <div class="media-body">
                                <div class="d-sm-flex justify-content-between mb-2">
                                    <h5 class="mb-sm-0"><?php echo $note->user_name_surname; ?><small class="text-muted ml-3"><?php echo timespan($post_date, $now, 3).' önce'; ?></small></h5>
                                    <div class="media-reply__link">
                                        <span class="label label-primary p-1"><?php echo $note->stage_name; ?></span>
                                        <span class="label label-secondary p-1"><?php echo $note->status_name; ?></span>
                                    </div>
                                </div>
                                <p><?php echo $note->note_content; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-3">Not Bulunmamaktadır.</h4>
                                </div>
                            </div>
                        </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body ">
                <h4 class="mb-3">Kayıt Bilgilerini Güncelle</h4>
                    <?php 
                        if($get_record->record_user_id == $this->session->userdata('user_id') || $get_record->record_user_id == 0 && $this->session->userdata('user_type') == 2){
                            echo form_open('record/update_record/'.$get_record->record_id); 
                        }
                    ?>
                    <div class="basic-form">
                        <div class="form-group">
                            <label>Ad Soyad</label>
                            <input type="text" name="name_surname" <?php echo ($get_record->record_user_id != $this->session->userdata('user_id') && $get_record->record_user_id > 0 || $this->session->userdata('user_type') == 1) ? "readonly" : ""; ?> class="form-control" value="<?php echo $get_record->record_name_surname; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Klinik Adı</label>
                            <input type="text" name="clinic_name" <?php echo ($get_record->record_user_id != $this->session->userdata('user_id') && $get_record->record_user_id > 0 || $this->session->userdata('user_type') == 1) ? "readonly" : ""; ?> class="form-control" value="<?php echo $get_record->record_clinic_name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Telefon</label>
                            <input type="text" name="phone" <?php echo ($get_record->record_user_id != $this->session->userdata('user_id') && $get_record->record_user_id > 0 || $this->session->userdata('user_type') == 1) ? "readonly" : ""; ?> maxlength="10" class="form-control" value="<?php echo $get_record->record_phone; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" name="email" <?php echo ($get_record->record_user_id != $this->session->userdata('user_id') && $get_record->record_user_id > 0 || $this->session->userdata('user_type') == 1) ? "readonly" : ""; ?> class="form-control" value="<?php echo !empty($get_record->record_email) ? $get_record->record_email : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label>Adres</label>
                            <textarea class="form-control" <?php echo ($get_record->record_user_id != $this->session->userdata('user_id') && $get_record->record_user_id > 0 || $this->session->userdata('user_type') == 1) ? "readonly" : ""; ?> name="address" rows="5"><?php echo !empty($get_record->record_address) ? $get_record->record_address : ''; ?></textarea>
                        </div>
                        <?php if($get_record->record_user_id == $this->session->userdata('user_id') || $get_record->record_user_id == 0 && $this->session->userdata('user_type') == 2): ?>
                            <button type="submit" class="btn btn-primary float-right">Bilgileri Güncelle</button>
                        <?php endif; ?> 
                    </div>
                    <?php 
                        if($get_record->record_user_id == $this->session->userdata('user_id') || $get_record->record_user_id == 0 && $this->session->userdata('user_type') == 2){
                            echo form_close();
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <p>Böyle bir kayıt bulunmamaktadır!</p>
<?php endif; ?>
