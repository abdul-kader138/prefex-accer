<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
	         'name',
	         'discription',
	         'hours_total',
	         'date'
	        ];

$sIndexColumn = 'id';
$sTable       = 'tblcostomerseminar';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
   	$row[] = '<a href="#" data-toggle="modal" data-target="#customer_seminar_modal" data-id="' . $aRow['id'] . '">' . $aRow["name"] . '</a>';
   	$row[]=$aRow['discription'];
   	$row[]=$aRow['hours_total'];
   	$row[]=_d($aRow['date']);
   	$options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#customer_seminar_modal', 'data-id' => $aRow['id']]);
    $row[]   = $options .= icon_btn('clients/delete_seminar/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
