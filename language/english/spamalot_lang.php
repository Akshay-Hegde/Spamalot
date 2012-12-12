<?php defined('BASEPATH') OR exit('No direct script access allowed');

	// General
	$lang['spamalot:title'] = 'Spamalot';
	$lang['spamalot:desc']  = 'Spam account detection';

	// Settings
	$lang['spamalot:settings:email_max']           = 'Email Max Frequency';
	$lang['spamalot:settings:email_max_inst']      = 'The maximum number of times an email can appear in the SFS database before being banned';
	$lang['spamalot:settings:ip_max']              = 'IP Max Frequency';
	$lang['spamalot:settings:ip_max_inst']         = 'The maximum number of times an ip address can appear in the SFS database before being banned';
	$lang['spamalot:settings:delete_account']      = 'Delete Account';
	$lang['spamalot:settings:delete_account_inst'] = 'When an account is flagged as spam would you like to delete it?';

	// Messages
	$lang['spamalot:sfs_spam'] = 'Your Email or IP Address has been detected as being potentially spam related, if you feel this is in error please contact the administrator to rectify this issue.';