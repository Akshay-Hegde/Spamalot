<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Spamalot extends Module {
	
	public $version = '0.2.0';

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
			'backend'		=> TRUE,
			'menu'	   		=> 'users',
			'author'   		=> 'Jamie Holdroyd'
		);
		
		return $info;
	}
	
	public function install()
	{

		// Load language
		$this->lang->load('spamalot/spamalot');

		#################
		## ADD LOGGING ##
		#################

		$this->db->query("CREATE TABLE IF NOT EXISTS `".SITE_REF."_spamalot_log` (
						    `id` int(6) NOT NULL AUTO_INCREMENT,
						    `first_seen` int(10) NOT NULL,
						    `last_seen` int(10) NOT NULL,
						    `ip` varchar(32) CHARACTER SET latin1 NOT NULL,
						    `email` varchar(255) CHARACTER SET latin1 NOT NULL,
						    `reported` tinyint(1) NOT NULL DEFAULT '0',
						    `attempts` int(6) NOT NULL DEFAULT '0',
						    `email_freq` int(6) NOT NULL DEFAULT '0',
						    `email_conf` float(5,2) NOT NULL DEFAULT '0.00',
						    `ip_freq` int(6) NOT NULL DEFAULT '0',
						    `ip_conf` float(5,2) NOT NULL DEFAULT '0.00',
						    PRIMARY KEY (`id`)
						  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

		##################
		## ADD SETTINGS ##
		##################

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
			'default'     => '5',
			'value'       => '5',
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

		$settings[] = array(
			'slug'        => 'spamalot_prereg',
			'title'       => lang('spamalot:settings:prereg'),
			'description' => lang('spamalot:settings:prereg_inst'),
			'default'     => '0',
			'value'       => '0',
			'type'        => 'select',
			'options'     => '1=Yes|0=No',
			'is_required' => 0,
			'is_gui'      => 1,
			'module'      => 'spamalot'
		);

		$settings[] = array(
			'slug'        => 'spamalot_cache_time',
			'title'       => lang('spamalot:settings:cache_time'),
			'description' => '',
			'default'     => '86400',
			'value'       => '86400',
			'type'        => 'text',
			'options'     => '',
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

		// Remove tables
		$this->dbforge->drop_table('spamalot_log');

		// Remove settings
		$this->db->where_in('slug', array(
			'spamalot_email_max',
			'spamalot_ip_max',
			'spamalot_confidence_min',
			'spamalot_delete_account',
			'spamalot_prereg',
			'spamalot_cache_time'
		))->delete('settings');

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
