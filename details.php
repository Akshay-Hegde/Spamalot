<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Spamalot extends Module {
	
	public $version = '0.1.0';

	public function info()
	{

		$info = array(
			'name' => array(
				'en' => 'Spamalot'
			),
			'description' => array(
				'en' => 'Spam account detection'
			),
			'frontend'		=> FALSE,
			'backend'		=> FALSE,
			'menu'	   		=> 'utilities',
			'author'   		=> 'Jamie Holdroyd'
		);
		
		return $info;
	}
	
	public function install()
	{

		// Load language
		$this->lang->load('spamalot/spamalot');

		// Variables
		$settings = array();

		// Create settings
		$settings[] = array(
			'slug'        => 'spamalot_email_max',
			'title'       => lang('spamalot:settings:email_max'),
			'description' => lang('spamalot:settings:email_max_inst'),
			'default'     => '3',
			'value'       => '3',
			'type'        => 'text',
			'options'     => '',
			'is_required' => 0,
			'is_gui'      => 1,
			'module'      => 'spamalot'
		);

		$settings[] = array(
			'slug'        => 'spamalot_ip_max',
			'title'       => lang('spamalot:settings:ip_max'),
			'description' => lang('spamalot:settings:ip_max_inst'),
			'default'     => '3',
			'value'       => '3',
			'type'        => 'text',
			'options'     => '',
			'is_required' => 0,
			'is_gui'      => 1,
			'module'      => 'spamalot'
		);

		$settings[] = array(
			'slug'        => 'spamalot_confidence_min',
			'title'       => lang('spamalot:settings:conf_min'),
			'description' => lang('spamalot:settings:conf_min_inst'),
			'default'     => '35',
			'value'       => '35',
			'type'        => 'text',
			'options'     => '',
			'is_required' => 0,
			'is_gui'      => 1,
			'module'      => 'spamalot'
		);

		$settings[] = array(
			'slug'        => 'spamalot_delete_account',
			'title'       => lang('spamalot:settings:delete_account'),
			'description' => lang('spamalot:settings:delete_account_inst'),
			'default'     => '0',
			'value'       => '0',
			'type'        => 'select',
			'options'     => '1=Yes|0=No',
			'is_required' => 0,
			'is_gui'      => 1,
			'module'      => 'spamalot'
		);

		// Add settings
		foreach( $settings as $setting )
		{
			$this->db->insert('settings', $setting);
		}

		return TRUE;
	}

	public function uninstall()
	{

		// Remove settings
		$this->db->where_in('slug', array('spamalot_email_max', 'spamalot_ip_max', 'spamalot_confidence_min', 'spamalot_delete_account'))->delete('settings');

		return TRUE;
	}

	public function upgrade($old_version)
	{

		return TRUE;
	}

	public function help()
	{

		return "Some Help Stuff";
	}

}
