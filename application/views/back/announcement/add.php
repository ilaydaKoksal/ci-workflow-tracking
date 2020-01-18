<div class="col-md-6">
    <div class="card">
        <div class="card-body ">
            <h4>Duyuru Oluştur</h4>
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
            <?php echo form_open('announcement/add_announcement', 'class="mt-5 mb-5 login-input"'); ?>
                <div class="form-group">
                    <label class="m-t-40">Tarih / Saat</label>
                    <label class="alert-danger float-right note"><i class="fas fa-exclamation"></i>  Duyurunuz hangi tarihe kadar çıksın?</label>
                    <input type="text" name="datetime" class="form-control" id="min-date" required>
                </div>
                <div class="form-group">
                    <label>Duyurunuz</label>
                    <textarea class="form-control" name="content" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn login-form__btn submit w-100">Duyuru Oluştur</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


