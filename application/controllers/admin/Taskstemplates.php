<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Taskstemplates extends Admin_controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($clientid = '')
    {
        $this->load->view('admin/tasks/tasktemplates' );
    }
}
