<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events_Spamalot
{

	protected $ci;

	public function __construct()
	{

		$this->ci =& get_instance();
		
		// Register events
		Events::register('post_user_register', array($this, 'post_user_register'));
		Events::register('public_controller', array($this, 'public_controller'));

	}

	public function public_controller()
	{

		// Load required items
		$this->ci->load->model('spamalot/spamalot_m');
		$this->ci->lang->load('spamalot/spamalot');

		// Variables
		$pages = array('activate', 'login', 'register');
		$ip    = $_SERVER['REMOTE_ADDR'];
		$cache = (int)$this->ci->settings->get('spamalot_cache_time');

		// Test access on significant user pages
		if( $this->ci->uri->rsegment(1) == 'users' and in_array($this->ci->uri->rsegment(2), $pages) )
		{

			// Check if we want to perform this check
			if( (bool)$this->ci->settings->get('spamalot_prereg') )
			{

				// Check details
				$spammer = $this->ci->pyrocache->model('spamalot_m', 'sfs_check', array(null, $ip), $cache);
				
				// Check spam result
				if( $spammer )
				{
					// Update flash message
					$this->ci->session->set_flashdata('error', lang('spamalot:sfs_spam'));
					redirect('404');
				}

			}

		}

	}

	public function post_user_register($id)
	{

		// Load required items
		$this->ci->load->model('spamalot/spamalot_m');
		$this->ci->lang->load('spamalot/spamalot');
		
		// Get user information
		$users = $this->ci->db->select('email, ip_address, username')->where('id', $id)->get('users');

		// Check for results
		if( $users->num_rows() )
		{

			// Variables
			$user  = current($users->result_array());
			$cache = (int)$this->ci->settings->get('spamalot_cache_time');

			// Check account against stopforumspam.com
			$spammer = $this->ci->pyrocache->model('spamalot_m', 'sfs_check', array($user['email'], $user['ip_address']), $cache);

			// Check spam result
			if( $spammer )
			{

				// Log action
				$log_id = $this->ci->spamalot_m->log_action($user['email'], $user['ip_address'], $this->ci->spamalot_m->response);

				// Report back to SFS
				$reported = $this->ci->spamalot_m->sfs_report($user['username'], $user['email'], $user['ip_address']);

				if( $log_id > 0 and $reported )
				{
					$this->ci->db->where('id', $log_id)->update('spamalot_log', array('reported' => 1));
				}

				// Delete account?
				if( (bool)$this->ci->settings->get('spamalot_delete_account', false) )
				{
					// Remove account
					$this->ci->db->where('id', $id)->delete('users');
					$this->ci->db->where('user_id', $id)->delete('profiles');
				}
				else
				{
					// Clear account settings
					$hash = 'spam_'.substr(md5(microtime()), 0, 27);
					$data = array('password' => $hash, 'active' => 0, 'activation_code' => $hash);
					$this->ci->db->where('id', $id)->update('users', $data);
				}

				// Update flash message
				$this->ci->session->set_flashdata('error', lang('spamalot:sfs_spam'));
				redirect('404');

			}

		}

	}

}
