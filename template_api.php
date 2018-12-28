<?php


ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

define('BASEPATH', "test");
$config  = include ("application/config/app-config.php");


$months = array(
                       1=> array('DisplayText'=>'January', 'Value'=>1, 'days'=>31),
                       2=> array('DisplayText'=>'February', 'Value'=>2, 'days'=>29),
                       3=> array('DisplayText'=>'March', 'Value'=>3, 'days'=>31),
                       4=> array('DisplayText'=>'April', 'Value'=>4, 'days'=>30),
                       5=> array('DisplayText'=>'May', 'Value'=>5, 'days'=>31),
                       6=> array('DisplayText'=>'June', 'Value'=>6, 'days'=>30),
                       7=> array('DisplayText'=>'July', 'Value'=>7, 'days'=>31),
                       8=> array('DisplayText'=>'August', 'Value'=>8, 'days'=>31),
                       9=> array('DisplayText'=>'September', 'Value'=>9, 'days'=>30),
                       10=> array('DisplayText'=>'October', 'Value'=>10, 'days'=>31),
                       11=> array('DisplayText'=>'November', 'Value'=>11, 'days'=>30),
                       12=> array('DisplayText'=>'December', 'Value'=>12, 'days'=>31),
                       101=> array('DisplayText'=>'December', 'Value'=>12, 'days'=>31)

);

$TypeOfDays = array (

);
                    $TypeOfDays [101]= array ('DisplayText'=> 'Everyday', 'Value'=> '101');
                    $TypeOfDays [102]= array ('DisplayText'=> 'First calendar day of the Month', 'Value'=> '102');
                    $TypeOfDays [103]= array ('DisplayText'=> 'Last calendar day of the Month', 'Value'=> '103');

try
{
	//Open database connection


	$con = mysqli_connect(APP_DB_HOSTNAME,APP_DB_USERNAME,APP_DB_PASSWORD);

    if (!$con) {
        #echo APP_DB_HOSTNAME.",".APP_DB_USERNAME.",".APP_DB_PASSWORD;
        die('Could not connect : ' );
    }
	mysqli_select_db( $con,APP_DB_NAME);

    //$_POST = array_map('mysql_real_escape_string',$_POST);
    //$_GET = array_map('mysql_real_escape_string',$_GET);


        if($_GET["tblclients_userid"]>0){
            if($_GET["do"] == "clienttemplate"){
                    //Getting records (listAction)
                    if($_GET["action"] == "list")
                    {
                        //Get record count
                        $result = mysqli_query($con,"SELECT COUNT(*) AS RecordCount FROM  tbltasktemplates_clients where tblclients_userid=".$_GET["tblclients_userid"]." ;");
                        $row = mysqli_fetch_array($result);
                        $recordCount = $row['RecordCount'];

                        $result = mysqli_query($con,"SELECT  *
                                FROM  tbltasktemplates_clients where tblclients_userid=".$_GET["tblclients_userid"]." ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");

                                #$result = mysqli_query($con,"SELECT * from  tbltasktemplates_clients ");

                        //Add all records to an array
                        $rows = array();
                        while($row = mysqli_fetch_array($result))
                        {
                            /*if($row['next_project_creation_date'] === "0000-00-00"){
                                  $row['next_project_creation_date'] = '<div style="color:red;">Not Valid Date</div>';
                            }
                            */
                            $rows[] = $row;
                        }

                        //Return result to jTable
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        $jTableResult['TotalRecordCount'] = $recordCount;
                        $jTableResult['Records'] = $rows;
                        print json_encode($jTableResult);
                    }
                    //Creating a new record (createAction)
                    else if($_GET["action"] == "create")
                    {

                        //Insert record into database
                        $result = mysqli_query($con,"INSERT INTO  tbltasktemplates_clients(tblclients_userid, tbltemplate_task_id,period_end_mm,period_end_dd,assigned_to)
                                 VALUES('" . $_POST["tblclients_userid"] . "', '" .$_POST["tbltemplate_task_id"] . "'
                                 , '0'
                                 , '0'
                                 , '" .$_POST["assigned_to"] . "'
                                 );");

                        //Get last inserted record (to return to jTable)
                        $result = mysqli_query($con,"SELECT * FROM tbltasktemplates_clients WHERE id = LAST_INSERT_ID();");
                        $row = mysqli_fetch_array($result);

                        //Return result to jTable
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        $jTableResult['Record'] = $row;
                        print json_encode($jTableResult);
                    }
                    //Updating a record (updateAction)
                    else if($_GET["action"] == "update")
                    {
                        //Update record in database
                        $result = mysqli_query($con,"UPDATE tbltasktemplates_clients SET tblclients_userid = '" . $_POST["tblclients_userid"] . "'
                        , tbltemplate_task_id = '" . $_POST["tbltemplate_task_id"] . "'
                        , period_end_mm = '0'
                        , period_end_dd = '0'
                        , assigned_to = '" . $_POST["assigned_to"] . "'
                                WHERE id = " . $_POST["id"] . ";");

                        //Return result to jTable
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        print json_encode($jTableResult);
                    }
                    //Deleting a record (deleteAction)
                    else if($_GET["action"] == "delete")
                    {
                        //Delete from database
                        $result = mysqli_query($con,"DELETE FROM tbltasktemplates_clients WHERE id = " . $_POST["id"] . ";");

                        //Return result to jTable
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        print json_encode($jTableResult);
                    }
            }//endif
         }//endif

        if($_GET["do"] == "task"){
                //Getting records (listAction)
                if($_GET["action"] == "list")
                {
                    //Get record count
                    $result = mysqli_query($con,"SELECT COUNT(*) AS RecordCount FROM  tblstafftemplate_tasks;");
                    $row = mysqli_fetch_array($result);
                    $recordCount = $row['RecordCount'];

                    $result = mysqli_query($con,"SELECT  *
                            FROM  tblstafftemplate_tasks ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");

                            #$result = mysqli_query($con,"SELECT * from  tblstafftemplate_tasks ");

                    //Add all records to an array
                    $rows = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        $rows[] = $row;
                    }

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['TotalRecordCount'] = $recordCount;
                    $jTableResult['Records'] = $rows;
                    print json_encode($jTableResult);
                }
                //Creating a new record (createAction)
                else if($_GET["action"] == "create")
                {
                    $startDate_ = 0;
                    //Insert record into database
                    $result = mysqli_query($con,"INSERT INTO  tblstafftemplate_tasks(name, description,billable,status,is_public,hourly_rate,template_task_start_date,template_duration,assigned_to,checklistitem,period_end_mm,period_end_dd,priority)
                             VALUES('" . $_POST["name"] . "', '" .$_POST["description"] . "',".
                             $_POST["billable"] . ",".
                             $_POST["status"] . ",".
                             $_POST["is_public"] . ",".
                             $_POST["hourly_rate"] . ",".
                             $startDate_. ",".
                             $_POST["template_duration"] . ",".
                             "'".$_POST["assigned_to"] . "'".
                             ",'".$_POST["checklistitem"] . "'".
                             ",'".$_POST["period_end_mm"] . "'".
                             ",'".$_POST["period_end_dd"] . "'".
                              ",'".$_POST["priority"] . "'".
                             ");");

                    //Get last inserted record (to return to jTable)
                    $result = mysqli_query($con,"SELECT * FROM tblstafftemplate_tasks WHERE id = LAST_INSERT_ID();");
                    $row = mysqli_fetch_array($result);

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Record'] = $row;
                    print json_encode($jTableResult);
                }
                //Updating a record (updateAction)
                else if($_GET["action"] == "update")
                {
                    //Update record in database
                    $startDate_ = 0;
                    $result = mysqli_query($con,"UPDATE tblstafftemplate_tasks SET name = '" . $_POST["name"] . "', description = '" . $_POST["description"] . "'
                            , billable = " . $_POST["billable"] . "
                            , is_public = " . $_POST["is_public"] . "
                               , status = " . $_POST["status"] . "
                            , hourly_rate = " . $_POST["hourly_rate"] . "
                            , template_task_start_date = 0
                            , assigned_to = '" . $_POST["assigned_to"] . "'
                            , template_duration = " . $_POST["template_duration"] . "
                            , checklistitem = '" . $_POST["checklistitem"] . "'
                              , period_end_mm = '" . $_POST["period_end_mm"] . "'
                                , period_end_dd = '" . $_POST["period_end_dd"] . "'
                                  , priority = '" . $_POST["priority"] . "'
                            WHERE id = " . $_POST["id"] . ";");

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    print json_encode($jTableResult);
                }
                //Deleting a record (deleteAction)
                else if($_GET["action"] == "delete")
                {
                    //Delete from database
                    $result = mysqli_query($con,"DELETE FROM tblstafftemplate_tasks WHERE id = " . $_POST["id"] . ";");

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    print json_encode($jTableResult);
                }
        }//endif
        if($_GET["do"] == "project"){
                //Getting records (listAction)
                if($_GET["action"] == "list")
                {
                    //Get record count
                    $result = mysqli_query($con,"SELECT COUNT(*) AS RecordCount FROM  tbltemplate_projects;");
                    $row = mysqli_fetch_array($result);
                    $recordCount = $row['RecordCount'];

                    //Get records from database
                    /*
                    $result = mysqli_query($con,"SELECT
                            id,name, description, project_created,project_cost,project_rate_per_hour,
                            recurringtypes.	recurringtype_name as recurring_type,
                            template_start_date,template_duration,template_periodend_dd,template_periodend_mm
                            FROM  tbltemplate_projects inner join recurringtypes on tbltemplate_projects.recurring_type = recurringtypes.recurringtype_id ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
                            */

                    $result = mysqli_query($con,"SELECT  *
                            FROM  tbltemplate_projects ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");

                            #$result = mysqli_query($con,"SELECT * from  tbltemplate_projects ");

                    //Add all records to an array
                    $rows = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        $rows[] = $row;
                    }

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['TotalRecordCount'] = $recordCount;
                    $jTableResult['Records'] = $rows;
                    print json_encode($jTableResult);
                }
                //Creating a new record (createAction)
                else if($_GET["action"] == "create")
                {
                    //Insert record into database
                    $result = mysqli_query($con,"INSERT INTO  tbltemplate_projects(name,  description, project_cost,status,project_rate_per_hour,	template_start_date,template_duration,assigned_to)
                             VALUES('" . $_POST["name"] . "', '" .$_POST["description"] . "',".
                             $_POST["project_cost"] . ",".
                             $_POST["status"] . ",".
                             $_POST["project_rate_per_hour"] . ",".
                             $_POST["template_start_date"] . ",".
                             $_POST["template_duration"] . ",".
                             "'".$_POST["assigned_to"] . "'".

                             ");");
                    //Get last inserted record (to return to jTable)
                    $result = mysqli_query($con,"SELECT * FROM tbltemplate_projects WHERE id = LAST_INSERT_ID();");
                    $row = mysqli_fetch_array($result);

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Record'] = $row;
                    print json_encode($jTableResult);
                }
                //Updating a record (updateAction)
                else if($_GET["action"] == "update")
                {
                    //Update record in database
                    $result = mysqli_query($con,"UPDATE tbltemplate_projects SET Name = '" . $_POST["name"] . "', description = '" . $_POST["description"] . "'
                            , project_cost = " . $_POST["project_cost"] . "
                             , status = " . $_POST["status"] . "
                            , project_rate_per_hour = " . $_POST["project_rate_per_hour"] . "
                            , assigned_to = '" . $_POST["assigned_to"] . "'
                            , template_duration = " . $_POST["template_duration"] . "
                            , template_start_date = " . $_POST["template_start_date"] . "
                            WHERE id = " . $_POST["id"] . ";");


                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    print json_encode($jTableResult);
                }
                //Deleting a record (deleteAction)
                else if($_GET["action"] == "delete")
                {
                    //Delete from database
                    $result = mysqli_query($con,"DELETE FROM tbltemplate_projects WHERE id = " . $_POST["id"] . ";");

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    print json_encode($jTableResult);
                }
        }//end projects

	 if($_GET["do"] == "generic"){
                if($_GET["action"] == "gettasktemplatenames")
                {
                    //Get record count
                    $result = mysqli_query($con,"SELECT COUNT(*) AS RecordCount FROM  tblstafftemplate_tasks;");
                    $row = mysqli_fetch_array($result);
                    $recordCount = $row['RecordCount'];

                    $result = mysqli_query($con,"SELECT  id,name
                            FROM  tblstafftemplate_tasks ORDER BY name;");

                            #$result = mysqli_query($con,"SELECT * from  tbltemplate_tasks ");

                    //Add all records to an array
                    $rows = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        array_push($rows , array ('DisplayText'=>$row ['name'], 'Value'=> $row ['id']));
                    }

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Options'] = $rows;
                    print json_encode($jTableResult);
                }
                else if($_GET["action"] == "getallassignedstaffbyprojecttemplateid")
                {
                    $result = mysqli_query($con,"SELECT  staffid,firstname,lastname
                            FROM  tblstaff where  id=".$_GET["recid"]." ;");

                    //Add all records to an array
                    $rows = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        array_push($rows , array ('DisplayText'=>$row ['firstname']. " " . $row ['lastname'], 'Value'=> $row ['staffid']));
                    }

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Options'] = $rows;
                    print json_encode($jTableResult);
                }
                else if($_GET["action"] == "getallstaff")
                {
                    //Get record count
                    $result = mysqli_query($con,"SELECT COUNT(*) AS RecordCount FROM  tblstaff;");
                    $row = mysqli_fetch_array($result);
                    $recordCount = $row['RecordCount'];

                    $result = mysqli_query($con,"SELECT  staffid,firstname,lastname
                            FROM  tblstaff ORDER BY firstname;");

                            #$result = mysqli_query($con,"SELECT * from  tbltemplate_tasks ");

                    //Add all records to an array
                    $rows = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        array_push($rows , array ('DisplayText'=>$row ['firstname']. " " . $row ['lastname'], 'Value'=> $row ['staffid']));
                    }

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Options'] = $rows;
                    print json_encode($jTableResult);
                }
                else if($_GET["action"] == "getpriority")
                {
                    //Get record count
                    $result = mysqli_query($con,"SELECT COUNT(*) AS RecordCount FROM  tblpriorities;");
                    $row = mysqli_fetch_array($result);
                    $recordCount = $row['RecordCount'];

                    $result = mysqli_query($con,"SELECT  priorityid,name
                            FROM  tblpriorities ORDER BY name;");

                            #$result = mysqli_query($con,"SELECT * from  tbltemplate_tasks ");

                    //Add all records to an array
                    $rows = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        array_push($rows , array ('DisplayText'=>$row ['name'], 'Value'=> $row ['priorityid']));
                    }

                    array_push($rows , array ('DisplayText'=>'Urgent', 'Value'=> '4'));

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Options'] = $rows;
                    print json_encode($jTableResult);
                }
                else if($_GET["action"] == "getclientNamebyid")
                {
                    //Get record count
                    $result = mysqli_query($con,"SELECT COUNT(*) AS RecordCount FROM  tblclients where active=1 and userid=".$_GET["myid"].";");
                    $row = mysqli_fetch_array($result);
                    $recordCount = $row['RecordCount'];

                    $result = mysqli_query($con,"SELECT  userid,company
                            FROM  tblclients where active=1 and userid=".$_GET["myid"]." ORDER BY company;");

                            #$result = mysqli_query($con,"SELECT * from  tbltemplate_tasks ");

                    //Add all records to an array
                    $rows = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        array_push($rows , array ('DisplayText'=>$row ['company'], 'Value'=> $row ['userid']));
                    }

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Options'] = $rows;
                    print json_encode($jTableResult);
                }
                else if($_GET["action"] == "getmonths")
                {
                    $rows = array ();
                    array_push($rows , array ('DisplayText'=>'All', 'Value'=> '101'));


                    foreach ($months as $i=>$v){
                      array_push($rows , array ('DisplayText'=>$v ['DisplayText'], 'Value'=> $v ['Value']));
                    }

                    array_push($rows , array ('DisplayText'=>'Quarterly - Jan,Apr,Jul,Oct', 'Value'=> '102'));
                    array_push($rows , array ('DisplayText'=>'Quarterly - Feb,May,Aug,Nov', 'Value'=> '103'));
                    array_push($rows , array ('DisplayText'=>'Quarterly - Mar,Jun,Sep,Dec', 'Value'=> '104'));

                    array_push($rows , array ('DisplayText'=>'Semi Yearly - Jan,Jul', 'Value'=> '105'));
                    array_push($rows , array ('DisplayText'=>'Semi Yearly - Feb,Aug', 'Value'=> '106'));
                    array_push($rows , array ('DisplayText'=>'Semi Yearly - Mar,Sep', 'Value'=> '107'));
                    array_push($rows , array ('DisplayText'=>'Semi Yearly - Apr,Oct', 'Value'=> '108'));
                    array_push($rows , array ('DisplayText'=>'Semi Yearly - May,Nov', 'Value'=> '109'));
                    array_push($rows , array ('DisplayText'=>'Semi Yearly - Jun,Dec', 'Value'=> '110'));

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Options'] = $rows;
                    print json_encode($jTableResult);
                }
                else if($_GET["action"] == "getdayofmonthbyrecid")
                {
                    $result = mysqli_query($con,"SELECT  period_end_dd
                            FROM  tblstafftemplate_tasks where  id=".$_GET["recid"]." ;");

                    //Add all records to an array
                    $rows = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        if(isset($TypeOfDays [$row ['period_end_dd']])){
                                 array_push($rows , array ('DisplayText'=>$TypeOfDays [$row ['period_end_dd']]['DisplayText'], 'Value'=> $TypeOfDays [$row ['period_end_dd']]['Value']));
                        } else {
                                 array_push($rows , array ('DisplayText'=>$row ['period_end_dd'], 'Value'=> $row ['period_end_dd']));
                        }
                        break;
                    }

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Options'] = $rows;
                    print json_encode($jTableResult);
                }
                else if($_GET["action"] == "getdayofmonthbymonthid")
                {
                    $period_end_mm = $_GET["period_end_mm"];

                    $rows =  array ();
                    foreach ($TypeOfDays as $i_=>$v_){
                         array_push($rows , array ('DisplayText'=> $v_ ['DisplayText'], 'Value'=> $v_ ['Value']));
                    }#end foreach

                    $maxDays = 28;
                    if(isset($months [$period_end_mm]['days'])){
                          $maxDays = $months [$period_end_mm]['days'];
                    } else {
                         if($period_end_mm>=100){
                              $maxDays = 31;
                         }
                    }

                    for($j=1;$j<=$maxDays;$j++){
                           array_push($rows , array ('DisplayText'=> 'Day '.$j, 'Value'=> $j));
                    }

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Options'] = $rows;
                    print json_encode($jTableResult);
                }
     }//end generic

	//Close database connection
	mysqli_close($con);

}
catch(Exception $ex)
{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}

?>
