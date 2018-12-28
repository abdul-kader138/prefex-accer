<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#customer_seminar_modal">New Customer Seminar</a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="row mbot15">
                        <div class="col-md-12">
                            <h4 class="no-margin">Seminars Summary</h4>
                        </div>
                        <div class="col-md-3 col-xs-6 border-right">
                            <?php if (isset($total_hours_years) && !empty($total_hours_years)): ?>
                            <?php $total_hour=0; foreach ($total_hours_years as $value): ?>
                            <?php 
                            $total_hour+=$value['hours_total']; 
                            ?>    
                            <?php endforeach ?>
                                
                            <?php endif ?>
                            <h3 class="bold"><?= $total_hour ?></h3>
                            <span class="text-dark">Total Hours</span>
                        </div>
                        <div class="col-md-3 col-xs-6 border-right">
                            <?php if (isset($total_hours_year) && !empty($total_hours_year)): ?>
                            <?php $total_hour=0; foreach ($total_hours_year as $value): ?>
                            <?php 
                            $total_hour+=$value['hours_total']; 
                            ?>    
                            <?php endforeach ?>
                                
                            <?php endif ?>
                            <h3 class="bold"><?= $total_hour ?></h3>
                            <span class="text-success">Total Hours(current years)</span>
                        </div>
                        <div class="col-md-3 col-xs-6 border-right">
                            <?php if (isset($total_hours_month) && !empty($total_hours_month)): ?>
                            <?php $total_hour=0; foreach ($total_hours_month as $value): ?>
                            <?php 
                            $total_hour+=$value['hours_total']; 
                            ?>    
                            <?php endforeach ?>
                                
                            <?php endif ?>
                            <h3 class="bold"><?= $total_hour ?></h3>
                            <span class="text-danger">Total Hours(current month)</span>
                        </div>
                        <div class="col-md-3 col-xs-6 border-right">
                            <?php if (isset($total_hours_day) && !empty($total_hours_day)): ?>
                            <?php $total_hour=0; foreach ($total_hours_day as $value): ?>
                            <?php 
                            $total_hour+=$value['hours_total']; 
                            ?>    
                            <?php endforeach ?>
                                
                            <?php endif ?>
                            <h3 class="bold"><?= $total_hour ?></h3>
                            <span class="text-info">Total Hours(current day)</span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        'Type of Seminar',
                        'Description',
                        'Hours Total',
                        'Date',
                        'Action'
                        ),'customer-seminar'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/clients/client_seminar'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-customer-seminar', window.location.href, [1], [1]);
   });
</script>
</body>
</html>
