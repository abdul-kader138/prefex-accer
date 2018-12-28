<div class="modal fade" id="customer_seminar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title">Edit Customer Seminar</span>
                    <span class="add-title">Add New Customer Seminar</span>
                </h4>
            </div>
            <?php echo form_open('admin/clients/seminar',array('id'=>'customer_seminars_modal')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                       
                        <?php echo form_hidden('id'); ?>
                         <?php echo render_input('name','customer_group_name'); ?>
                         <div class="form-group">
                             <label class="control-label"> Description</label>
                              <textarea class="form-control" name="discription"></textarea> 
                             
                         </div>
                         <div class="form-group">
                             <label class="control-label"> Hours Total</label>
                              <input type="text" name="hours_total" class="form-control">
                             
                         </div>
                        
                        
                        <?php $value = (isset($invoice) ? _d($invoice->date) : '');
                          $date_attrs = array();
                          ?>
                          <?php echo render_date_input('date','date',$value,$date_attrs); ?>   
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('load',function(){
       _validate_form($('#customer_seminars_modal'), {
        name: 'required',
        hours_total: 'required',
        date:'required',
    }, manage_customer_groups);

       $('#customer_seminar_modal').on('show.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);
        var group_id = $(invoker).data('id');
        $('#customer_seminar_modal .add-title').removeClass('hide');
        $('#customer_seminar_modal .edit-title').addClass('hide');
        $('#customer_seminar_modal input[name="id"]').val('');
        $('#customer_seminar_modal input[name="name"]').val('');
        // is from the edit button
        if (typeof(group_id) !== 'undefined') {
            $('#customer_seminar_modal input[name="id"]').val(group_id);
            $('#customer_seminar_modal .add-title').addClass('hide');
            $('#customer_seminar_modal .edit-title').removeClass('hide');
            $('#customer_seminar_modal input[name="name"]').val($(invoker).parents('tr').find('td').eq(0).text());
        }
    });
   });
    function manage_customer_groups(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                if($.fn.DataTable.isDataTable('.table-customer-seminar')){
                    $('.table-customer-seminar').DataTable().ajax.reload();
                }
                
                alert_float('success', response.message);
            }
            $('#customer_seminar_modal').modal('hide');
        });
        return false;
    }

</script>
