<div class="row">
    <?php if($this->session->flashdata('msg') != ''): ?>
        <div class="col-md-12">
            <div class="alert alert-success flash-msg alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4>Başarılı!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        </div>
    <?php endif; ?>	
    <?php if($this->session->flashdata('error') != ''): ?>
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4>Hata!</h4>
                <?php echo $this->session->flashdata('error'); ?> 
            </div>
        </div>
    <?php endif; ?>	
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body ">
                    <?php if(!empty($get_stages)): ?>
                        <h4 class="mb-3"><?php echo $title; ?></h4>
                        <?php echo form_open('stage_status/stage_detail/'.$get_stages->stage_id); ?>
                            <div class="basic-form">
                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <input type="text" name="stage_name" class="form-control" placeholder="Aşama Adı" value="<?php echo $get_stages->stage_name; ?>" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" class="btn btn-primary">Güncelle</button>
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    <?php elseif(!empty($get_status)): ?>
                        <h4 class="mb-3"><?php echo $title; ?></h4>
                        <?php echo form_open('stage_status/status_detail/'.$get_status->status_id); ?>
                            <div class="basic-form">
                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <input type="text" name="status_name" class="form-control" placeholder="Durum Adı" value="<?php echo $get_status->status_name; ?>" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" class="btn btn-primary">Güncelle</button>
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    <?php else: ?>
                        <p>Böyle bir aşama / durum bulunmamaktadır!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
