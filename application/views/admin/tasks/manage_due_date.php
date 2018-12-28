<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row _buttons">
                            <div class="col-md-8">
                                <?php if(has_permission('tasks','','create')){ ?>
                                    <a href="#" onclick="new_task_due_date(<?php if($this->input->get('project_id')){ echo "'".admin_url('tasks/task_due_date?rel_id='.$this->input->get('project_id').'&rel_type=project')."'";} ?>); return false;" class="btn btn-info pull-left new"><?php echo _l('new_task'); ?></a>
                                <?php } ?>
                                <a href="<?php if(!$this->input->get('project_id')){ echo admin_url('tasks/switch_kanban/'.$switch_kanban); } else { echo admin_url('projects/view/'.$this->input->get('project_id').'?group=project_tasks'); }; ?>" class="btn btn-default mleft10 pull-left hidden-xs">
                                    <?php if($switch_kanban == 1){ echo _l('switch_to_list_view');}else{echo _l('leads_switch_to_kanban');}; ?>
                                </a>
                                <a href="#" onclick="showSummary(); return false;" class="btn btn-default mleft10 pull-left">Summary</a>
                            </div>
                            <div class="col-md-4">
                                <?php if($this->session->has_userdata('tasks_kanban_view') && $this->session->userdata('tasks_kanban_view') == 'true') { ?>
                                    <div data-toggle="tooltip" data-placement="bottom" data-title="<?php echo _l('search_by_tags'); ?>">
                                        <?php echo render_input('search','','','search',array('data-name'=>'search','onkeyup'=>'tasks_kanban();','placeholder'=>_l('search_tasks')),array(),'no-margin') ?>
                                    </div>
                                <?php } else { ?>
                                    <?php $this->load->view('admin/tasks/tasks_filter_by',array('view_table_name'=>'.table-tasks-due-date')); ?>
                                    <a href="<?php echo admin_url('tasks/detailed_overview_due_date'); ?>" class="btn btn-success pull-right mright5"><?php echo _l('detailed_overview'); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <hr class="hr-panel-heading hr-10" />
                        <div class="clearfix"></div>
                        <?php
                        if($this->session->has_userdata('tasks_kanban_view') && $this->session->userdata('tasks_kanban_view') == 'true') { ?>
                            <div class="kan-ban-tab" id="kan-ban-tab" style="overflow:auto;">
                                <div class="row">
                                    <div id="kanban-params">
                                        <?php echo form_hidden('project_id',$this->input->get('project_id')); ?>
                                    </div>
                                    <div class="container-fluid">
                                        <div id="kan-ban"></div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="summarytab" id="ctlsummarytab">
                                <?php $this->load->view('admin/tasks/_summary',array('table'=>'.table-tasks-due-date')); ?>
                            </div>
                            <a href="#" data-toggle="modal" data-target="#tasks_bulk_actions" class="hide bulk-actions-btn table-btn" data-table=".table-tasks-due-date"><?php echo _l('bulk_actions'); ?></a>
                            <?php $this->load->view('admin/tasks/_table',array('bulk_actions'=>true)); ?>
                            <?php $this->load->view('admin/tasks/_bulk_actions'); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    taskid = '<?php echo $taskid; ?>';
    $(function(){
        tasks_kanban();
    });


    function new_task_due_date(url) {
        url = typeof(url) != 'undefined' ? url : admin_url + 'tasks/task_due_date';

        var $leadModal = $('#lead-modal');
        if ($leadModal.is(':visible')) {
            url += '&opened_from_lead_id=' + $leadModal.find('input[name="leadid"]').val();
            if (url.indexOf('?') === -1) {
                url = url.replace('&', '?');
            }
            $leadModal.modal('hide');
        }

        var $taskSingleModal = $('#task-modal');
        if ($taskSingleModal.is(':visible')) {
            $taskSingleModal.modal('hide');
        }

        var $taskEditModal = $('#_task_modal');
        if ($taskEditModal.is(':visible')) {
            $taskEditModal.modal('hide');
        }

        requestGet(url).done(function (response) {
            $('#_task').html(response);
            $("body").find('#_task_modal').modal({show: true, backdrop: 'static'});
        });
    }

        // kader
</script>
</body>
</html>
