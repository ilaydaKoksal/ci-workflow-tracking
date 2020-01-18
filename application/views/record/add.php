<div class="col-md-8">
    <div class="card">
        <div class="card-body ">
            <h4 class="mb-3"><?php echo $title; ?></h4>
                <?php if($this->session->flashdata('msg') != ''): ?>
                    <div class="alert alert-success flash-msg alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4>Başarılı!</h4>
                        <?php echo $this->session->flashdata('msg'); ?>
                        <script>
                            setTimeout(function(){   
                            window.location="<?php echo base_url('record/add'); ?>";
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
            <?php echo form_open('record/add_record'); ?>
                <div class="basic-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Ad Soyad</label>
                            <input type="text" name="name_surname" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Klinik Adı</label>
                            <input type="text" name="clinic_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Telefon</label>
                            <input type="text" name="phone" maxlength="10" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>E-mail</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Adres</label>
                        <textarea class="form-control" name="address" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Kaydet</button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>