<?php init_head(); ?>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">-->
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<style>
    select {
        padding: 9px;
        border: solid 1px #03a9f4;
        outline: 0;
        background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, rgba(35, 12, 60, 0.07)), to(#FFFFFF));
        background: -moz-linear-gradient(top, #FFFFFF, #C6ECFF 1px, #FFFFFF 25px);
        box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;
        -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;
        -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;

    }
    input {
        padding: 9px;
        border: solid 1px #03a9f4;
        outline: 0;
        background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, rgba(35, 12, 60, 0.07)), to(#FFFFFF));
        background: -moz-linear-gradient(top, #FFFFFF, #C6ECFF 1px, #FFFFFF 25px);
        box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;
        -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;
        -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;

    }

    textarea {
        width: 600px;
        height: 120px;
        font-family: Roboto;
        /*border: 1px solid #0077B0;*/
        border: 1px solid #03a9f4;
        padding: 5px;
        font-family: Tahoma, sans-serif;
        background-position: bottom right;
        background-repeat: no-repeat;
    }
    .ui-dialog-title{
        font-size: 20px;
        color: white;
        font-weight: bold;
        font-family: Roboto;
    }
    .jtable-input-label{
        color: #415165;
        font-weight: bold;
        font-family: Roboto;
    }
    /*#AddRecordDialogSaveButton,#EditDialogSaveButton {*/
    /*background-color: #03a9f4;*/
    /*}*/

    .ui-dialog{
        width: 500px !important;
        height: auto;
    }
    .ui-widget{
        width: 500px !important;
        height: auto;
    }
    .ui-dialog-content{
        width: 500px !important;
        height: auto;
    }

    .ui-widget-content{
        width: 500px !important;
        height: auto;
    }
    .ui-dialog-buttonpane {
        width: 490px !important;
        height: auto;
    }

    /*.ui-icon-closethick,.ui-dialog-titlebar-close{*/
    /*background-color: #415165;*/
    /*}*/
</style>

<link href="<?php echo base_url('assets/themes/prefex/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">

      <div class="panel_s">
          <div class="panel-body _buttons">
                            <h2>Task Templates</h2>
                            <div class="alert alert-info" role="alert">Use following table to add/view/insert/delete task templates</div>
              </div>
       </div>

        <div class="panel_s">
          <div class="panel-body">

             <div class="row mbot15">
                <div class="col-md-12">
                  <h3 class="text-success no-margin">Task Templates</h3>
                </div>
             </div>
             <div class="clearfix"></div>

          <div id="TemplateTasks" style="width:  ;"></div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
<script>
		$(document).ready(function () {



		    //Prepare jTable
			$('#TemplateTasks').jtable({
				title: 'Tasks',
				paging: true,
				pageSize: 20,
				sorting: true,
				defaultSorting: 'name ASC',
				actions: {
					listAction: '/accer/template_api.php?do=task&action=list',
					createAction: '/accer/template_api.php?do=task&action=create',
					updateAction: '/accer/template_api.php?do=task&action=update',
					deleteAction: '/accer/template_api.php?do=task&action=delete'
				},
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					name: {
						title: 'Task Template Name',
						width: '20%',
                        text:'bold'
					},
					description: {
						title: 'Description',
					},
					billable: {
						title: 'Billable',
						options: { '0': 'Non Billable', '1': 'Billable' }
					},
					is_public: {
						title: 'Public',
						options: { '0': 'Private', '1': 'Public' }
					},
					status: {
						title: 'Default Status',
						options: { '1': 'Not Started', '2': 'Awaiting Feedback' , '3': 'Testing', '4': 'In Progress', '5': 'Complete'}
					},
					priority: {
						title: 'Default Priority',
						options : '/accer/template_api.php?do=generic&action=getpriority'
					},
          period_end_mm: {
						title: "Period End Month",
				                 options : "/accer/template_api.php?do=generic&action=getmonths"
					},
					period_end_dd: {
						title: "Period End Day",
						dependsOn: "period_end_mm",
                                                options: function (data) {
                                                    if (data.source == "list") {
                                                        //Return url of all countries for optimization.
                                                        //This method is called for each row on the table and jTable caches options based on this url.
                                                        return "/accer/template_api.php?do=generic&action=getdayofmonthbyrecid&recid="+data.record.id;
                                                    }

                                                    //This code runs when user opens edit/create form or changes continental combobox on an edit/create form.
                                                    //data.source == "edit" || data.source == "create"
                                                    return "/accer/template_api.php?do=generic&action=getdayofmonthbymonthid&period_end_mm=" + data.dependedValues.period_end_mm;
                                                }
					} ,
					template_duration: {
						title: 'Duration (Relative To Period End)',
            options: {
              '900': '1st Calendar Day of Next Month (Max 1 Day)',
              '901': '15th Calendar Day of Next Month (Max 15 Days)',
              '99': 'Last Calendar Day of Next Month (Max 31 Days)',
            }
					},
					hourly_rate: {
						title: 'Hourly rate',
					},
					assigned_to: {
						title: "Default Assignee",
                                                options: function (data) {
                                                    if (data.source == "list") {
                                                        //Return url of all countries for optimization.
                                                        //This method is called for each row on the table and jTable caches options based on this url.
                                                        return "/accer/template_api.php?do=generic&action=getallstaff";
                                                    }

                                                    //This code runs when user opens edit/create form or changes continental combobox on an edit/create form.
                                                    //data.source == "edit" || data.source == "create"
                                                    return "/accer/template_api.php?do=generic&action=getallstaff";
                                                }
					},
					checklistitem: {
						title: 'Checklist Items <small>One item per line</small>',
						type : 'textarea',
						list: false
					}
				}
			});

			//Load person list from server
			$('#TemplateTasks').jtable('load');
            $(".jtable-toolbar").on('click', function(event){
                $(".ui-dialog-titlebar-close").html("<span class='ui-button-icon-info ui-icon ui-icon-closethick' style='color: #000000'></span>");
            });
            var elements_top = $('div.ui-dialog-titlebar');
            var elements_bottom = $('div.ui-dialog-buttonpane');
            elements_top.each(function() { $(this).css("background-color","#415165;"); });
            elements_bottom.each(function() { $(this).css("background-color","#415165"); });
		});
</script>
<link href="<?php echo base_url('assets/plugins/jtable/themes/lightcolor/blue/accerp.css'); ?>" rel="stylesheet" type="text/css" />
<!--<script src="/assets/plugins/jtable/jquery.jtable.2.4.0.js" type="text/javascript"></script>-->
<script src="<?php echo base_url('assets/plugins/jtable/jquery.jtable.2.4.0.js'); ?>"></script>
</body>
</html>
