<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Member';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

#$route['event'] = 'Page/index';
#$route['register'] = 'Page/register';

$route['admin']						= 'admin/Admin/index/';
$route['admin/login']				= 'admin/Admin/login/';
$route['admin/logout']				= 'admin/Admin/logout/';
$route['admin/search']				= 'admin/Admin/search/';
$route['admin/detail/(:any)']		= 'admin/Admin/detail/$1';

$route['admin/codes/generate']		= 'admin/Codes/generate/';
$route['admin/codes/listings']		= 'admin/Codes/listings/';
$route['admin/codes/ajax/(:any)']	= 'admin/Codes/ajax/$1';

$route['admin/encashments']							= 'admin/Encashment/index/';
$route['admin/encashment/payouts']					= 'admin/Encashment/payouts/';
$route['admin/encashment/details/(:any)']			= 'admin/Encashment/details/$1';
$route['admin/encashment/process']					= 'admin/Encashment/process/';
$route['admin/encashment/ajax/(:any)']				= 'admin/Encashment/ajax/$1';
$route['admin/encashment/export-payout/(:any)']		= 'admin/Encashment/export_payout/$1';

$route['admin/rewards']						= 'admin/Claims/index/';
$route['admin/rewards/claims']				= 'admin/Claims/claims/';
$route['admin/rewards/ajax/(:any)']			= 'admin/Claims/ajax/$1';
$route['admin/encashment/export-claims/(:any)']		= 'admin/Claims/export_claims/$1';

$route['admin/settings/encashment-settings']	= 'admin/Settings/settings_encashment/';
$route['admin/settings/elite-settings']			= 'admin/Settings/settings_elite/';
$route['admin/settings/maintenance-settings']	= 'admin/Settings/settings_maintenance/';
$route['admin/settings/rewards']				= 'admin/Settings/rewards/';
$route['admin/settings/announcements']			= 'admin/Settings/announcements/';
$route['admin/settings/ajax/(:any)']			= 'admin/Settings/ajax/$1';
$route['admin/settings/reward-form/(:num)']		= 'admin/Settings/reward_form/$1';
$route['admin/settings/announcement-form/(:num)']		= 'admin/Settings/annoucement_form/$1';

$route['admin/leadership']							= 'admin/Leadership/index/';
$route['admin/leadership/process/']					= 'admin/Leadership/process/';
$route['admin/leadership/history/']					= 'admin/Leadership/history/';
$route['admin/leadership/history-detail']			= 'admin/Leadership/history_details/';
$route['admin/leadership/history-detail-level']		= 'admin/Leadership/history_level/';
$route['admin/leadership/history-gsc']				= 'admin/Leadership/history_gsc/';
$route['admin/leadership/export-breakdown/(:num)/(:any)']	= 'admin/Leadership/export_breakdown/$1/$2';
$route['admin/leadership/ajax/(:any)']				= 'admin/Leadership/ajax/$1';

$route['admin/members/search']					= 'admin/Members/search/';
$route['admin/members/add']						= 'admin/Members/add_member/';
$route['admin/members/export']					= 'admin/Members/export/';
$route['admin/members/ajax/(:any)']				= 'admin/Members/ajax/$1';
$route['admin/members/detail/(:any)']			= 'admin/Members/detail/$1';
$route['admin/members/update-personal-info/(:num)']	= 'admin/Members/update_personal_info/$1';
$route['admin/members/upload-valid-photo/(:num)']	= 'admin/Members/upload_valid_photos/$1';
$route['admin/members/update-password/(:num)']		= 'admin/Members/update_password/$1';
$route['admin/members/bank-information/(:num)']		= 'admin/Members/update_bank_info/$1';
$route['admin/members/security-pin/(:num)']			= 'admin/Members/security_pin/$1';
$route['admin/members/block-account/(:num)']		= 'admin/Members/block_account/$1';
$route['admin/members/update-email/(:num)']			= 'admin/Members/update_email/$1';
$route['admin/members/member-status/(:num)']		= 'admin/Members/member_status/$1';
$route['admin/members/activate-member/(:num)']		= 'admin/Members/activate_member/$1';
$route['admin/members/activate-encashment/(:num)']	= 'admin/Members/activate_encashment/$1';
$route['admin/members/resend-activation/(:num)']	= 'admin/Members/resend_activation/$1';

$route['admin/heads/search']					= 'admin/Heads/search/';
$route['admin/heads/ajax/(:any)']				= 'admin/Heads/ajax/$1';
$route['admin/heads/detail/(:any)']				= 'admin/Heads/detail/$1';
$route['admin/heads/export']					= 'admin/Heads/export/';
$route['admin/heads/update-balance/(:num)']		= 'admin/Heads/update_balance/$1';

$route['admin/packages']						= 'admin/Packages/index/';
$route['admin/packages/package-form/(:num)']	= 'admin/Packages/package_form/$1';
$route['admin/packages/ajax/(:any)']			= 'admin/Packages/ajax/$1';

$route['admin/reports/auto-paid']				= 'admin/Reports/auto_paid/';
$route['admin/reports/ajax/(:any)']				= 'admin/Reports/ajax/$1';

#$route['(:any)']					= 'Page/index/$1';


#member routes

$route['/']								= 'Member/index/';
$route['dashboard']						= 'Member/dashboard/';
$route['maintenance']					= 'Member/maintenance/';
$route['blocked']						= 'Member/blocked/';
$route['login']							= 'Member/login/';
$route['profile']						= 'Member/profile/';
$route['member/update-personal-info/']	= 'Member/update_personal_info/';
$route['member/upload-valid-photo']		= 'Member/upload_valid_photos/';
$route['member/update-password']		= 'Member/update_password/';
$route['member/bank-information']		= 'Member/update_bank_info/';
$route['member/security-pin']			= 'Member/security_pin/';
$route['activate/(:any)']				= 'Member/activate/$1';
$route['activate/(:any)/(:any)']		= 'Member/activate/$1/$2';
$route['forgot-password']				= 'Member/forgot_password/';
$route['forgot-password/(:any)']		= 'Member/forgot_password/$1';
$route['mailtest']						= 'Page/mailtest/';
$route['bulk_sender']					= 'Page/bulk_sender/';
$route['generate_qrcode']				= 'Page/generate_qrcode/';
$route['vcard/(:any)']					= 'Page/vcard/$1';
$route['ajax/(:any)']					= 'Page/ajax/$1';
$route['view/annoucements']				= 'Member/view_announcements/';
$route['annoucement/details/(:num)']	= 'Member/announcement_details/$1';

$route['rewards']						= 'Rewards/view_rewards/';
$route['reward/details/(:any)']			= 'Rewards/details/$1';

$route['member/logout']					= 'Member/logout/';
$route['member/add']					= 'Member/add/';
$route['member/add/heads']				= 'Member/add_heads/';
$route['member/form']					= 'Member/form/';
$route['member/search']					= 'Member/search/';
$route['member/genealogy']				= 'Genealogy/index/';
$route['member/downline-genealogy']		= 'Genealogy/member_genealogy/';

$route['codes/listing']					= 'Codes/codes/';
$route['codes/transfer-history']		= 'Codes/transfer_history/';
$route['codes/used-history']			= 'Codes/used_history/';
$route['codes/transfer']				= 'Codes/transfer/';

$route['transactions/wallet']						= 'Transactions/wallet/';
$route['transactions/move-to-wallet']				= 'Transactions/move_wallet/';
$route['transactions/wallet-history/']				= 'Transactions/wallet_history/';
$route['transactions/star-wallet']					= 'Transactions/star_wallet/';
$route['transactions/move-to-star-wallet']			= 'Transactions/move_star_wallet/';
$route['transactions/star-wallet-history/']			= 'Transactions/star_wallet_history/';
$route['transactions/gsc-history/']					= 'Transactions/gsc_history/';
$route['transactions/leadership-history/']			= 'Transactions/leadership_history/';
$route['transactions/leadership-history-details/(:any)']		= 'Transactions/leadership_details_history/$1';
$route['transactions/leadership-level-details/(:any)']	= 'Transactions/leadership_level_history/$1';

$route['request/encashment']						= 'Requests/request_encashment/';
$route['request/rewards']							= 'Requests/request_rewards/';
$route['request/encashment-history']				= 'Requests/encashment_history/';
$route['request/reward-history']					= 'Requests/claim_history/';