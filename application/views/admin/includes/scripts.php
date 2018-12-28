<?php include_once(APPPATH.'views/admin/includes/helpers_bottom.php'); ?>
<?php do_action('before_js_scripts_render'); ?>
<script src="<?php echo base_url('assets/plugins/app-build/vendor.js?v='.get_app_version()); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery/jquery-migrate.'.(ENVIRONMENT === 'production' ? 'min.' : '').'js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/datatables.min.js?v='.get_app_version()); ?>"></script>
<script src="<?php echo base_url('assets/plugins/app-build/moment.min.js'); ?>"></script>
<?php app_select_plugin_js($locale); ?>
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js?v='.get_app_version()); ?>"></script>
<?php app_jquery_validation_plugin_js($locale); ?>
<?php if(get_option('dropbox_app_key') != ''){ ?>
<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="<?php echo get_option('dropbox_app_key'); ?>"></script>
<?php } ?>
<?php if(isset($media_assets)){ ?>
<script src="<?php echo base_url('assets/plugins/elFinder/js/elfinder.min.js'); ?>"></script>
<?php if(file_exists(FCPATH.'assets/plugins/elFinder/js/i18n/elfinder.'.get_media_locale($locale).'.js') && get_media_locale($locale) != 'en'){ ?>
<script src="<?php echo base_url('assets/plugins/elFinder/js/i18n/elfinder.'.get_media_locale($locale).'.js'); ?>"></script>
<?php } ?>
<?php } ?>
<?php if(isset($projects_assets)){ ?>
<script src="<?php echo base_url('assets/plugins/jquery-comments/js/jquery-comments.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/gantt/js/jquery.fn.gantt.min.js'); ?>"></script>
<?php } ?>
<?php if(isset($circle_progress_asset)){ ?>
<script src="<?php echo base_url('assets/plugins/jquery-circle-progress/circle-progress.min.js'); ?>"></script>
<?php } ?>
<?php if(isset($calendar_assets)){ ?>
<script src="<?php echo base_url('assets/plugins/fullcalendar/fullcalendar.min.js?v='.get_app_version()); ?>"></script>
<?php if(get_option('google_api_key') != ''){ ?>
<script src="<?php echo base_url('assets/plugins/fullcalendar/gcal.min.js'); ?>"></script>
<?php } ?>
<?php if(file_exists(FCPATH.'assets/plugins/fullcalendar/locale/'.$locale.'.js') && $locale != 'en'){ ?>
<script src="<?php echo base_url('assets/plugins/fullcalendar/locale/'.$locale.'.js'); ?>"></script>
<?php } ?>
<?php } ?>
<script src="<?php echo base_url('assets/js/ttt.js'); ?>"></script>
<?php //echo app_script('assets/js','main.js'); ?>
<?php
/**
 * Global function for custom field of type hyperlink
 */
echo get_custom_fields_hyperlink_js_function(); ?>
<?php
/**
 * Check for any alerts stored in session
 */
app_js_alerts();
?>
<?php
/**
 * Check pusher real time notifications
 */
if(get_option('pusher_realtime_notifications') == 1){ ?>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script type="text/javascript">
 $(function(){
   // Enable pusher logging - don't include this in production
   // Pusher.logToConsole = true;
   <?php $pusher_options = do_action('pusher_options',array());
   if(!isset($pusher_options['cluster']) && get_option('pusher_cluster') != ''){
     $pusher_options['cluster'] = get_option('pusher_cluster');
   } ?>
   var pusher_options = <?php echo json_encode($pusher_options); ?>;
   var pusher = new Pusher("<?php echo get_option('pusher_app_key'); ?>", pusher_options);
   var channel = pusher.subscribe('notifications-channel-<?php echo get_staff_user_id(); ?>');
   channel.bind('notification', function(data) {
      fetch_notifications();
   });
});
</script>
<?php } ?>
<?php
/**
 * End users can inject any javascript/jquery code after all js is executed
 */
do_action('after_js_scripts_render');
?>

<?php
  if(isset($this ->_ci_cached_vars['group']) && strtolower($this ->_ci_cached_vars['group']) === "projecttemplates_clients"){
    $client__id = $this ->_ci_cached_vars['client']->userid;?>

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
          .ui-dialog-title{
              font-size: 20px;
              color: #000000;
              font-weight: bold;
          }
          .jtable-input-label{
              color: black;
              font-weight: bold;
          }
      </style>

      <link href="<?php echo base_url('assets/plugins/jtable/themes/lightcolor/blue/accerp.css'); ?>" rel="stylesheet" type="text/css" />
      <script src="<?php echo base_url('assets/plugins/jtable/jquery.jtable.2.4.0.js'); ?>"></script>
    <?php echo '
<!-- Task   Template -->
<script>
		$(document).ready(function () {

		    //Prepare jTable
			$("#TemplateClients").jtable({
				title: "Services",
				paging: true,
				pageSize: 20,
				sorting: true,
				defaultSorting: "tblclients_userid ASC",
				actions: {
					listAction: "/accer/template_api.php?tblclients_userid='.$client__id.'&do=clienttemplate&action=list",
					createAction: "/accer/template_api.php?tblclients_userid='.$client__id.'&do=clienttemplate&action=create",
					updateAction: "/accer/template_api.php?tblclients_userid='.$client__id.'&do=clienttemplate&action=update",
					deleteAction: "/accer/template_api.php?tblclients_userid='.$client__id.'&do=clienttemplate&action=delete"
				},
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					tblclients_userid: {
						title: "Client",
                                                options : "/accer/template_api.php?do=generic&action=getclientNamebyid&myid='.$client__id.'"
					},
					tbltemplate_task_id: {
						title: "Task Template",
				                 options : "/accer/template_api.php?do=generic&action=gettasktemplatenames"
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
					}
				}
			});

			$("#TemplateClients").jtable("load");
			$(".jtable-toolbar").on(\'click\', function(event){
                $(".ui-dialog-titlebar-close").html("<span class=\'ui-button-icon-info ui-icon ui-icon-closethick\' style=\'color: #000000\'></span>");
            });
            var elements_top = $(\'div.ui-dialog-titlebar\');
            var elements_bottom = $(\'div.ui-dialog-buttonpane\');
            elements_top.each(function() { $(this).css("background-color","rgb(3, 169, 244);"); });
            elements_bottom.each(function() { $(this).css("background-color","rgb(3, 169, 244);"); });

		});
</script>
    ';
  }#endif
?>
