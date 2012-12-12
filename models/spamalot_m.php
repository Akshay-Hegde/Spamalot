<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class spamalot_m extends MY_Model {


	public function check_sfs($email, $ip)
	{

		// Variables
		$email = urlencode($email);
		$ip    = urlencode($ip);
		$url   = "http://www.stopforumspam.com/api?email={$email}&ip={$ip}";
		$total = 0;

		// Settings
		$email_max_frequency = (int)$this->settings->get('spamalot_email_max', 3);
		$ip_max_frequency    = (int)$this->settings->get('spamalot_ip_max', 3);

		// Get API response
		$xml = (array)simplexml_load_file($url);

		// Check response
		if( $xml['@attributes']['success'] == 'true' )
		{

			// Check frequency of Email
			if( $xml['appears'][0] == 'yes' and (int)$xml['frequency'][0] >= $email_max_frequency )
			{
				return true;
			}

			// Check frequency of IP
			if( $xml['appears'][1] == 'yes' and (int)$xml['frequency'][1] >= $ip_max_frequency )
			{
				return true;
			}

		}

		return false;
	}

}
