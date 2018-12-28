<?php

ini_set('display_errors',1);
ini_set('display_startup_errors', E_ALL);
error_reporting(1);

define('BASEPATH', "test");
$config  = include ("application/config/app-config.php");
$automatedTesting = false;

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
                               12=> array('DisplayText'=>'December', 'Value'=>12, 'days'=>31)
        );

#Todays date
$today_YY_ = date("Y");
$today_MM_ = date("m");
$today_DD_ = date("d");

#For custom dates or testing

$today_YY_ = "2018";
$today_MM_ = "02";
$today_DD_ = "28";


$counter = 0;
init ($months, $automatedTesting, $config, $today_YY_, $today_MM_, $today_DD_ , $counter++) ;

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
function init ($months, $automatedTesting, $config, $today_YY_, $today_MM_, $today_DD_, $counter){
        $todayDate = "$today_YY_-$today_MM_-$today_DD_";
        echo "<br> Assumed Today is : $todayDate </br>";
        try
        {
        	$con = mysqli_connect(APP_DB_HOSTNAME,APP_DB_USERNAME,APP_DB_PASSWORD);
            if (!$con) {
                #echo APP_DB_HOSTNAME.",".APP_DB_USERNAME.",".APP_DB_PASSWORD;
                die('Could not connect : ' . mysqli_error());
            }
        	mysqli_select_db( $con,APP_DB_NAME);

               $query = "select distinct
               ".$tablPrefix."tblstafftemplate_tasks.name as  tbltemplate_tasks_name,
               template_duration,
               tbltemplate_task_id,
               tblclients_userid,
               template_task_start_date,
               tbltasktemplates_clients.assigned_to as service_assigned_to,
               tblstafftemplate_tasks.period_end_mm as  period_end_mm,
               tblstafftemplate_tasks.period_end_dd as period_end_dd,
               tblstafftemplate_tasks.id as tblstafftemplate_tasks_id
               from ".$tablPrefix."tbltasktemplates_clients
               inner join ".$tablPrefix."tblstafftemplate_tasks on ".$tablPrefix."tblstafftemplate_tasks.id = ".$tablPrefix."tbltasktemplates_clients.tbltemplate_task_id";

               //echo $query;
               $result = mysqli_query($con,$query);
               while($row = mysqli_fetch_array($result))
               {

                                  print_r($row);

                                  #  get period end month
                                  $myMonth = 0;
                                  $today_YY= $today_YY_;
                                  $today_MM= $today_MM_;
                                  $today_DD= $today_DD_;
                                  switch ($row ['period_end_mm']) {
                                       case "101":
                                           #for all months
                                           $myMonth =  $today_MM_;
                                           break;
                                       case "102":
                                           #Jan,Apr,Jul,Oct
                                           if($today_MM == "01" || $today_MM == "04"  || $today_MM == "07"  || $today_MM == "10" ){$myMonth=$today_MM_;}break;
                                       case "103":
                                           #Feb,May,Aug,Nov
                                           if($today_MM == "02" || $today_MM == "05"  || $today_MM == "08"  || $today_MM == "11" ){$myMonth=$today_MM_;}break;
                                       case "104":
                                           #Mar,Jun,Sep,Dec
                                           if($today_MM == "03" || $today_MM == "06"  || $today_MM == "09"  || $today_MM == "12" ){$myMonth=$today_MM_;}break;
                                       case "105":
                                           #Jan,Jul
                                           if($today_MM == "01" || $today_MM == "07" ){$myMonth=$today_MM_;}break;
                                       case "106":
                                           if($today_MM == "02" || $today_MM == "08" ){$myMonth=$today_MM_;}break;
                                       case "107":

                                           if($today_MM == "03" || $today_MM == "09" ){$myMonth=$today_MM_;}break;
                                       case "108":

                                           if($today_MM == "04" || $today_MM == "10" ){$myMonth=$today_MM_;}break;
                                       case "109":

                                           if($today_MM == "05" || $today_MM == "11" ){$myMonth=$today_MM_;}break;
                                       case "110":

                                           if($today_MM == "06" || $today_MM == "12" ){$myMonth=$today_MM_;}break;
                                       default:
                                           $myMonth=$row ['period_end_mm'];
                                           break;

                                  }#end switch

                                  #now get period end day
                                  $period_end_dd = $row ['period_end_dd'];
                                  switch ($row ['period_end_dd']) {
                                       case "101":
                                           #for all days
                                           $period_end_dd =  $today_DD_;
                                           break;
                                       case "102":
                                           if($today_DD_ == "01"){
                                             $period_end_dd="01";
                                           } else {
                                             $period_end_dd = 0;
                                           }
                                           break;
                                       case "103":
                                           $dayNo = cal_days_in_month(CAL_GREGORIAN, $myMonth, $today_YY);
                                           if($today_DD_ == $dayNo){
                                             $period_end_dd=$dayNo;
                                           } else {
                                             $period_end_dd = 0;
                                           }
                                           break;
                                  }#end switch



                                  echo "<br> Task Start Date";
                                  echo "<br> $today_YY_ - $myMonth - $period_end_dd"   ;

                                  if($today_YY_ &&  $myMonth && $period_end_dd){
                                        #Today is the day to make task

                                                                                  if(true)
                                                                                  {
                                                                                    $template_duration_task = $row ['template_duration'];

                                                                                    //Get duration - jaswinder
                                                                                    $dayNo = $period_end_dd ;
                                                                                    $monNo = $myMonth;
                                                                                    $yearNo = $today_YY_;

                                                                                    $total_days_in_this_month = cal_days_in_month(CAL_GREGORIAN, $myMonth, $today_YY_);
                                                                                    if($total_days_in_this_month == $period_end_dd){
                                                                                      //This period end is on last day of month so lets add another month to duration

                                                                                      if($myMonth == 12){
                                                                                        $monNo = 1;
                                                                                        $yearNo++;
                                                                                      } else {
                                                                                        $monNo++;
                                                                                      }

                                                                                    }


                                                                                    switch ($row ['template_duration']) {
                                                                                         case "99":
                                                                                             $dayNo = cal_days_in_month(CAL_GREGORIAN, $monNo, $yearNo);
                                                                                             break;
                                                                                        case "900":
                                                                                             $dayNo = 1;
                                                                                             break;
                                                                                        case "901":
                                                                                             $dayNo = 15;
                                                                                             break;
                                                                                        case "902":
                                                                                              $effectiveDate = date('Y-m-d', strtotime("+1 months", strtotime("$yearNo-$monNo-$dayNo")));
                                                                                              $yearNo = date('Y',$effectiveDate);
                                                                                              $monNo= date('m',$effectiveDate);
                                                                                              $dayNo = cal_days_in_month(CAL_GREGORIAN, $monNo, $yearNo);
                                                                                             break;
                                                                                        case "903":
                                                                                              $effectiveDate = date('Y-m-d', strtotime("+1 months", strtotime("$yearNo-$monNo-$dayNo")));
                                                                                              $yearNo = date('Y',$effectiveDate);
                                                                                              $monNo= date('m',$effectiveDate);
                                                                                              $dayNo = 1;
                                                                                              break;
                                                                                        case "904":
                                                                                              $effectiveDate = date('Y-m-d', strtotime("+1 months", strtotime("$yearNo-$monNo-$dayNo")));

                                                                                              echo "<br> 904 ($yearNo-$monNo-$dayNo):" ;
                                                                                              date_format($effectiveDate,"Y/m/d  ");

                                                                                              $yearNo = date('Y',$effectiveDate);
                                                                                              $monNo= date('m',$effectiveDate);
                                                                                              $dayNo = 15;
                                                                                              break;
                                                                                    }#end switch
                                                                                    echo "<br>Task End Date : $yearNo-$monNo-$dayNo";
                                                                                    $Insert_template_duration_task = date ("$yearNo-$monNo-$dayNo");


                                                                                    $Insert_template_task_start_date = date("$today_YY_-$today_MM_-$today_DD_");

                                                                                      $select = "select * from ".$tablPrefix."tblstafftemplate_tasks where id=".$row ['tblstafftemplate_tasks_id'];
                                                                                      $result_2 = mysqli_query($con,$select);
                                                                                      while($row_2 = mysqli_fetch_array($result_2))
                                                                                      {



                                                                                            $pri =  trim($row_2 ['priority']);
                                                                                            if(!$pri){
                                                                                                      $pri = 0;
                                                                                            }#endif

                                                                                            $addedFrom = 0;
                                                                                            if($row_2 ['addedfrom']){
                                                                                                $addedFrom = $row_2 ['addedfrom'];

                                                                                            }//endif
                                                                                            $repeat_every = 0;
                                                                                            if($row_2 ['repeat_every']){
                                                                                                $repeat_every = $row_2 ['repeat_every'];
                                                                                            }//endif
                                                                                            $recurring_ends_on = 'NULL';
                                                                                            if($row_2 ['recurring_ends_on']){
                                                                                                $recurring_ends_on = "'". $row_2 ['recurring_ends_on']."'";
                                                                                            }//endif
                                                                                            $last_recurring_date = 'NULL';
                                                                                            if($row_2 ['last_recurring_date']){
                                                                                                $last_recurring_date = "'".$row_2 ['last_recurring_date']."'";
                                                                                            }//endif



                                                                                            #Insert Tasks
                                                                                            $sql = "INSERT INTO `".$tablPrefix."tblstafftasks` (`name`, `description`, `priority`, `dateadded`, `startdate`, `duedate`,
                                                                                            `datefinished`, `addedfrom`, `status`, `recurring_type`, `repeat_every`, `recurring`,
                                                                                            `recurring_ends_on`, `custom_recurring`, `last_recurring_date`, `rel_id`, `rel_type`, `is_public`,
                                                                                            `billable`, `billed`, `invoice_id`, `hourly_rate`, `milestone`, `kanban_order`,
                                                                                            `milestone_order`, `visible_to_client`, `deadline_notified`) VALUES
                                                                                            ('".$row_2 ['name']."', '".$row_2 ['description']."',
                                                                                            $pri,
                                                                                            '$Insert_template_task_start_date','$Insert_template_task_start_date','$Insert_template_duration_task','$Insert_template_duration_task',
                                                                                            '".$addedFrom."',
                                                                                            '".$row_2 ['status']."',
                                                                                            '".$row_2 ['recurring_type']."',
                                                                                            '".$repeat_every."',
                                                                                            '".$row_2 ['recurring']."',
                                                                                            ".$recurring_ends_on.",
                                                                                            '".$row_2 ['custom_recurring']."',
                                                                                            ".$last_recurring_date.",
                                                                                            ".$row ['tblclients_userid'].",
                                                                                            'customer',
                                                                                            '".$row_2 ['is_public']."',
                                                                                            '".$row_2 ['billable']."',
                                                                                            '".$row_2 ['billed']."',
                                                                                            '".$row_2 ['invoice_id']."',
                                                                                            '".$row_2 ['hourly_rate']."',
                                                                                            '".$row_2 ['milestone']."',
                                                                                            '".$row_2 ['kanban_order']."',
                                                                                            '".$row_2 ['milestone_order']."',
                                                                                            '".$row_2 ['visible_to_client']."',
                                                                                            '".$row_2 ['deadline_notified']."');";

                                                                                            $result_1 = mysqli_query($con,$sql);
                                                                                            $taskId = mysqli_insert_id ($con);

                                                                                            echo "<br> Creating Tasls From Template : ";
                                                                                            echo $sql;
                                                                                            if(!$taskId){
                                                                                               echo "<div style='color:red'>Query Failed</div>";
                                                                                            }{

                                                                                                  $query = '  INSERT INTO tblstafftemplate_tasks_recurring (tblstafftasks_id, is_recurring) VALUES ($taskId,1 )';
                                                                                                  $result_2 = mysqli_query($con,$query);

                                                                                                if($row ['service_assigned_to']) {
                                                                                                    $assignee = 'INSERT INTO `'.$tablPrefix.'tblstafftaskassignees` ( `staffid`, `taskid`, `assigned_from`)
                                                                                                    VALUES ( '.$row ['service_assigned_to'].', '.$taskId.', 1);';
                                                                                                    echo "<br />".$assignee;
                                                                                                    $result_1 = mysqli_query($con,$assignee);

                                                                                                    echo "\nchecklistitem\n";
                                                                                                    print_r($checklistitem);
                                                                                                    /* Pull Checklist */
                                                                                                    $checklistitem = explode("\n", $row_2 ['checklistitem']);
                                                                                                    foreach ($checklistitem as $ck_i=>$ck_v){
                                                                                                          $ck_v = trim($ck_v);
                                                                                                          if(!$ck_v){
                                                                                                               continue;
                                                                                                          }//endif

                                                                                                          $checklist_item = 'INSERT INTO `'.$tablPrefix.'tbltaskchecklists` ( `taskid`, `description`, `dateadded`,`addedfrom`,`finished_from`,`list_order` )
                                                                                                          VALUES ( '.$taskId.', '."'".$ck_v."'".', now(), '.$row ['service_assigned_to'].', 8, 1);';
                                                                                                          echo "<br />".$checklist_item;
                                                                                                          $result_2 = mysqli_query($con,$checklist_item);
                                                                                                    }//end foreach


                                                                                                }
                                                                                            }#endif
                                                                                            echo "<br><br>";


                                                                                      }#end while task
                                                                                    }#end if

                                  }//endif





               }#end while



               echo "<br > *********************END ************************";
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
}#end function

function isTodayLastDayOfTheMonth ($today_YY,$today_MM,$today_DD){
            $t=date($today_DD.'-'.$today_MM.'-'.$today_YY);
            $day = strtolower(date("D",strtotime($t)));
            $month = strtolower(date("m",strtotime($t)));
            $dayNum = strtolower(date("d",strtotime($t)));
            $weekno = floor(($dayNum - 1) / 7) + 1;

            if($weekno=="4" or $weekno=="5")
            {
                $Date = date($today_DD.'-'.$today_MM.'-'.$today_YY);
                $new_month = date('m', strtotime($Date. ' + 7 days'));
                if($new_month != $month)
                {
                    return true;
                }
            }
            return false;
}#end function

?>
