<div class="card">
    <div class="card-body">
        <?php if(!empty($get_all)): ?>
            <div class="card-title">
                <h4><?php echo $title; ?></h4>
            </div>
            <?php echo empty($id) ? form_open('transfer/transfer') : form_open('transfer/transfer/'.$id); ?>
                <div class="row">
                    <div class="col-md-12">
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
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style='width: 25%'>Ad Soyad</th>
                                        <th style='width: 30%'>Klinik Adı</th>
                                        <th style='width: 30%'>Klinik Adresi</th>
                                        <th style='width: 5%'>Seç</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($get_all as $record): ?>
                                    <tr>
                                        <td><?php echo $record->record_name_surname; ?></td>
                                        <td><?php echo $record->record_clinic_name; ?></td>
                                        <td><?php echo $record->record_address; ?></td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="check[]" value="<?php echo $record->record_id; ?>" class="custom-control-input" id="<?php echo $record->record_id; ?>">
                                                <label class="custom-control-label" for="<?php echo $record->record_id; ?>">Seç</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="basic-form mt-3">
                            <div class="form-group">
                            <label>Kişi Seç</label>
                                <select name="select" class="form-control">
                                    <option value="0">Aktaracağınız kişiyi seçiniz..</option>
                                    <?php foreach($get_users as $user): ?>
                                        <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name_surname; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Aktar</button>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
        <?php else: ?>
            <p>Kayıt bulunamadı!</p>
        <?php endif; ?>
    </div>
</div>
