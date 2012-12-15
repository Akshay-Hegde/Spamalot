<?php defined('BASEPATH') OR exit('No direct script access allowed');

	// General
	$lang['spamalot:title'] = 'Spamalot';
	$lang['spamalot:desc']  = 'Spam account detection';

	// Logs
	$lang['spamalot:section:logs']        = 'Account Detection Logs';
	$lang['spamalot:label_first_seen']    = 'First Seen';
	$lang['spamalot:label_last_seen']     = 'Last Seen';
	$lang['spamalot:label_ip']            = 'IP Address';
	$lang['spamalot:label_email']         = 'Email Address';
	$lang['spamalot:label_reported']      = 'Reported';
	$lang['spamalot:label_reported_desc'] = 'Was the account reported to StopForumSpam.com?';
	$lang['spamalot:label_attempts']      = 'Attempts';
	$lang['spamalot:label_email_freq']    = 'Email Frequency';
	$lang['spamalot:label_email_conf']    = 'Email Confidence';
	$lang['spamalot:label_ip_freq']       = 'IP Frequency';
	$lang['spamalot:label_ip_conf']       = 'IP Confidence';
	$lang['spamalot:label_no_logs']       = 'No Logs Found';

	// Settings
	$lang['spamalot:settings:email_max']           = 'Email Max Frequency';
	$lang['spamalot:settings:email_max_inst']      = 'The maximum number of times an email can appear in the SFS database before being banned';
	$lang['spamalot:settings:ip_max']              = 'IP Max Frequency';
	$lang['spamalot:settings:ip_max_inst']         = 'The maximum number of times an ip address can appear in the SFS database before being banned';
	$lang['spamalot:settings:conf_min']            = 'Minimum Confidence';
	$lang['spamalot:settings:conf_min_inst']       = 'Minimum required confidence in percent before a ban/disable is issued';
	$lang['spamalot:settings:delete_account']      = 'Delete Account';
	$lang['spamalot:settings:delete_account_inst'] = 'When an account is flagged as spam would you like to delete it?';
	$lang['spamalot:settings:prereg']              = 'Check IP on User Pages';
	$lang['spamalot:settings:prereg_inst']         = 'Perform an IP check before registration, login or activation';
	$lang['spamalot:settings:cache_time']          = 'Cache Time in Seconds';
	$lang['spamalot:settings:apikey']              = '<a href="http://www.stopforumspam.com/signup" target="_blank">StopForumSpam.com</a> API Key';
	$lang['spamalot:settings:apikey_inst']         = 'Adding a key will automatically report spam registrations back to the database';

	// Messages
	$lang['spamalot:sfs_spam'] = 'Your Email or IP Address has been detected as being potentially spam related, if you feel this is in error please contact the administrator to rectify this issue.';