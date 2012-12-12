<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class spamalot_m extends MY_Model {


	public function check_sfs($email, $ip)
	{

		// Variables
		$email = urlencode($email);
		$ip    = urlencode($ip);
		$url   = "http://www.stopforumspam.com/api?f=json&email={$email}&ip={$ip}&confidence";
		$total = 0;

		// Settings
		$email_max_frequency = (int)$this->settings->get('spamalot_email_max', 3);
		$ip_max_frequency    = (int)$this->settings->get('spamalot_ip_max', 3);
		$min_confidence      = (int)$this->settings->get('spamalot_confidence_min', 35);

		// Get API response
		$data = file_get_contents($url);
		$json = json_decode($data);

		// Check response
		if( $json->success )
		{

			// Check frequency of Email
			if( $json->email->appears == 1 and $json->email->frequency >= $email_max_frequency )
			{
				return true;
			}

			// Check email confidence levels
			if( isset($json->email->confidence) and $json->email->confidence >= $min_confidence )
			{
				return true;
			}

			// Check frequency of IP
			if( $json->ip->appears == 1 and $json->ip->frequency >= $ip_max_frequency )
			{
				return true;
			}

			// Check ip confidence levels
			if( isset($json->ip->confidence) and $json->ip->confidence >= $min_confidence )
			{
				return true;
			}

		}

		return false;
	}

}
