<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	
	public $perpage = 30;

    public function __construct()
    {
        parent::__construct();

		// Load libraries
		$this->lang->load('spamalot');
		$this->load->model('spamalot_m');

		// Add data object
		$this->data = new stdClass;
		
	}

	public function index($start = 0)
	{

		// Get log data
		$this->data->logs = $this->spamalot_m->log_get($start, $this->perpage);

		// Build pagination
		// TODO: this bit

		// Build the page
		$this->template->title(lang('spamalot:title'))
					   ->build('admin/index', $this->data);
	}

}
