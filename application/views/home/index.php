<div class="row">
    <?php $i = 1; ?>
    <?php if(!empty($get_stage)): ?>
        <?php foreach($get_stage as $stage): ?>
            <div class="col-lg-3 col-sm-6">
                <a href="<?php echo base_url('record/all_record/'.$stage->stage_id); ?>">
                    <div class="card gradient-1">
                        <div class="card-body">
                            <h3 class="card-title text-white"><?php echo $stage->stage_name; ?></h3>
                            <div class="d-inline-block">
                                <h2 class="text-white"><?php echo count($this->all->get_all('records', array('record_stage' => $stage->stage_id, 'record_user_id' => $this->session->userdata('user_id')))); ?></h2>
                                <p class="text-white mb-0"><?php echo $i.'. Aşama'; ?></p>
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fas fa-angle-double-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if(!empty($get_announcement || !empty($get_announcements))): ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4>Duyurular</h4>
                    </div>
                    <?php foreach($get_announcement as $anno): ?>
                        <?php 
                            $post_date = strtotime($anno->note_datetime);
                            $now = time();
                            $now_time = new DateTime(date('Y-m-d H:i:s'));
                            $end_time= new DateTime($anno->note_datetime);
                            $calc = $now_time->diff($end_time);
                            //diff:Returns the difference between two DateTime objects
                        ?>
                        <?php if($calc->invert != 1 && $calc->days < 6): ?>
                            <div class="alert alert-primary"><i class="fas fa-bomb"></i>
                                <?php echo '<b>'.$anno->record_name_surname.'</b>'.' adlı müşteriniz ile olan '.'<b>'.$anno->stage_name.'</b>'.' aşamasındaki '.'<b>'.$anno->status_name.'</b>'.' durumundaki görevinize '.'<b>'.timespan($now, $post_date, 5).'</b>'.' kaldı!.'; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php foreach($get_announcements as $annos): ?>
                        <?php if(strtotime($annos->announcement_date) > strtotime(date('Y-m-d H:i:s'))): ?>
                            <div class="alert alert-primary"><i class="fas fa-exclamation-triangle"></i>
                                <?php echo $annos->announcement_content; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>