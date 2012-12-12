<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events_Spamalot
{

	protected $ci;

	public function __construct()
	{

		$this->ci =& get_instance();
		
		// register the events
		Events::register('post_user_register', array($this, 'post_user_register'));

	}

	public function post_user_register($id)
	{

		// Load required items
		$this->ci->load->model('spamalot/spamalot_m');
		$this->ci->lang->load('spamalot/spamalot');
		
		// Get user information
		$users = $this->ci->db->where('id', $id)->get('users');

		// Check for results
		if( $users->num_rows() )
		{

			// Get account details
			$user = current($users->result_array());

			// Check account against stopforumspam.com
			$spammer = $this->ci->spamalot_m->check_sfs($user['email'], $user['ip_address']);

			// Check spam result
			if( $spammer )
			{

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
