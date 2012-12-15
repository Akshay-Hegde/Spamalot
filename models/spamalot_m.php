<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class spamalot_m extends MY_Model {

	public $response;

	public function sfs_check($email = null, $ip = null)
	{

		// Variables
		$email = urlencode($email);
		$ip    = urlencode($ip);
		$url   = "http://www.stopforumspam.com/api?f=json&confidence";
		$total = 0;

		// Settings
		$email_max_frequency = (int)$this->settings->get('spamalot_email_max', 3);
		$ip_max_frequency    = (int)$this->settings->get('spamalot_ip_max', 3);
		$min_confidence      = (int)$this->settings->get('spamalot_confidence_min', 35);

		// Append to URL
		$url .= ( $email != null ? "&email={$email}" : "" );
		$url .= ( $ip != null ? "&ip={$ip}" : "" );

		// Get API response
		$json = file_get_contents($url);
		$json = json_decode($json);

		// Add data to response
		$this->response = $json;

		// Check response
		if( $json != null and $json->success )
		{

			if( $email != null )
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
			}

			if( $ip != null )
			{
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

		}

		return false;
	}

	public function sfs_report($username, $email, $ip)
	{

		// Check reporting and get key
		if( $key = $this->settings->get('spamalot_apikey') )
		{

			// Variables
			$url  = "http://www.stopforumspam.com/add.php?";
			$data = array(
				'api_key'  => $key,
				'username' => $username,
				'email'    => $email,
				'ip_addr'  => $ip
			);

			// Make request
			$response = file_get_contents($url.http_build_query($data));
			$response = strip_tags($response);

			// Check for success
			return ( $response == 'data submitted successfully' ? true : false );
		}

		return false;
	}

	public function log_action($email, $ip, $response)
	{

		// Check for existing data
		$query = $this->db->select('id, attempts')->where('email', $email)->or_where('ip', $ip)->get('spamalot_log');

		// Check for existing entries
		if( $query->num_rows() )
		{

			$results = $query->result_array();

			// Loop and update results
			foreach( $results as $result )
			{
				$data = array('last_seen' => now(), 'attempts' => ( $result['attempts'] + 1 ));
				$this->db->where('id', $result['id'])->update('spamalot_log', $data);
			}

			return (int)$result['id'];
		}

		// Prepare new log entry
		$data = array(
			'first_seen' => now(),
			'last_seen'  => now(),
			'ip'         => $ip,
			'email'      => $email,
			'reported'   => 0,
			'attempts'   => 1,
			'email_freq' => $response->email->frequency,
			'email_conf' => ( isset($response->email->confidence) ? $response->email->confidence : 0.00 ),
			'ip_freq'    => $response->ip->frequency,
			'ip_conf'    => ( isset($response->ip->confidence) ? $response->ip->confidence : 0.00 )
		);

		// Add it
		$this->db->insert('spamalot_log', $data);

		// Send ID back
		return (int)$this->db->insert_id();
	}

	public function log_get($start, $limit)
	{

		// Run query
		$query = $this->db->order_by('last_seen', 'asc')
						  ->limit($limit, $start)
						  ->get('spamalot_log');

		// Check for results
		if( $query->num_rows() )
		{
			return $query->result_array();
		}

		// Nothing found
		return array();
	}

	public function log_count()
	{

		return $this->db->get('spamalot_log')->num_rows();
	}

}
