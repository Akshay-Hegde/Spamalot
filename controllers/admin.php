<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	
	public $perpage = 20;

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
		$total = $this->spamalot_m->log_count();
		$this->data->pagination = create_pagination('admin/spamalot/', $total, $this->perpage, $uri_segment = 3);

		// Build the page
		$this->template->title(lang('spamalot:title'))
					   ->append_css('module::spamalot.css')
					   ->build('admin/index', $this->data);
	}

}
