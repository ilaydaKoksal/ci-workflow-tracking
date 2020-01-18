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
                    <h4 class="mb-3"><?php echo $title1; ?></h4>
                    <?php echo form_open('stage_status/add_stage'); ?>
                        <div class="basic-form">
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <input type="text" name="stage_name" class="form-control" placeholder="Aşama Adı" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-primary">Kaydet</button>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body ">            
                    <h4 class="mb-3"><?php echo $title2; ?></h4>
                    <?php echo form_open('stage_status/add_status'); ?>
                        <div class="basic-form">
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <input type="text" name="status_name" class="form-control" placeholder="Durum Adı" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-primary">Kaydet</button>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body "> 
                    <?php if(!empty($get_stage) && $get_stage != ''): ?>
                        <?php echo form_open('stage_status/stage_sort', 'basic_form'); ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style='width: 55%;'>Aşamalar</th>
                                            <th style='width: 30%;'>Sırala</th>
                                            <th style='width: 15%;'>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($get_stage as $stage): ?>
                                        <tr>
                                            <td><?php echo $stage->stage_name; ?></td>
                                            <td style='text-align:center;'>
                                                <div class="form-group">
                                                    <select name="slc[<?php echo $stage->stage_id; ?>]" class="form-control slc" id="sel1">
                                                        <option value="0">Seç</option>
                                                        <?php for($i=1;$i<=count($get_stage);$i++): ?>
                                                            <option value="<?php echo $i; ?>" <?php echo ($stage->stage_rank == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>    
                                            </td>
                                            <td style='text-align:center;'>
                                                <a class="m-2" href="<?php echo base_url('stage_status/delete_stage/'.$stage->stage_id); ?>"><i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Sil"></i></a>
                                                <a href="<?php echo base_url('stage_status/stage_page/'.$stage->stage_id); ?>"><i class="fas fa-qrcode" data-toggle="tooltip" data-placement="top" title="Düzenle"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-primary float-right" style="margin-right: 20%;padding-right: 35px;padding-left: 35px;">Sırala</button>
                            </div>
                        <?php echo form_close(); ?>
                    <?php else: ?>
                        <p>Kayıtlı aşama bulunmamaktadır.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body "> 
                    <?php if(!empty($get_status) && $get_status != ''): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style='width: 85%;'>Durumlar</th>
                                        <th style='width: 15%;'>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($get_status as $status): ?>
                                    <tr>
                                        <td><?php echo $status->status_name; ?></td>
                                        <td style='text-align:center;'>
                                            <a class="m-2" href="<?php echo base_url('stage_status/delete_status/'.$status->status_id); ?>"><i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Sil"></i></a>
                                            <a href="<?php echo base_url('stage_status/status_page/'.$status->status_id); ?>"><i class="fas fa-qrcode" data-toggle="tooltip" data-placement="top" title="Düzenle"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>Kayıtlı durum bulunmamaktadır.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
