<div class="col-md-6">
    <div class="card">
        <div class="card-body ">
            <h4>Üye Ekle</h4>
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
            <?php echo form_open('admin/add_member', 'class="mt-5 mb-5 login-input"'); ?>
                <div class="form-group">
                    <input type="text" name="name_surname" class="form-control"  placeholder="Ad Soyad" required>
                </div>
                <div class="form-group">
                    <input type="phone" name="phone" maxlength="10" class="form-control"  placeholder="Telefon" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control"  placeholder="E-mail" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Şifre" required>
                </div>
                <button type="submit" class="btn login-form__btn submit w-100">Üye Ekle</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


