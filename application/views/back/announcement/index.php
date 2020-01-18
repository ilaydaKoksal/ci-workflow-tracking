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
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style='width: 95%'>Duyuru</th>
                            <th style='width: 5%'>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($get_all as $anno): ?>
                        <tr>
                            <td><?php echo $anno->announcement_content; ?></td>
                            <td style="text-align:center">
                                <a href="<?php echo base_url('announcement/detail/'.$anno->announcement_id); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Detaylar"><i class="fas fa-qrcode mr-2"></i></a>
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
