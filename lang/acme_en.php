<?php
namespace GDO\ACME\lang;
return [
	
	'module_acme' => 'Let\'s Encrypt',
	'acme_challenges' => ['Staging', 'HTTP', 'DNS'],
	
	'acme_algorithm' => 'Crypto-Algorithm',
	'acme_challenge_time' => 'Challenge Timeout',
	'cfg_acme_staging_mode' => 'Staging mode?',
	'cfg_acme_account_email' => 'Account E-Mail',
	
	'acme_link_issue' => 'Issue new Cert',
	'acme_link_renew' => 'Renew a Cert',
	
	'mt_acme_account' => 'ACME Account',
	'mt_acme_admin' => 'ACME Administration',
	'mt_acme_renew' => 'Renew your TLS Cert',
	'mt_acme_cronjob' => 'ACME Renewal Cronjob',
	
	'mt_acme_issue' => 'Issue a new TLS Cert',
	'err_acme_dns' => 'This module does not feature DNS ACME challenges yet.',
	'err_acme_domain' => 'Your configured domain is invalid: "%s".',
	'err_acme_challenge' => 'We failed solving the ACME %s challenge. Reason: "%s".',
	'msg_acme_challenge' => "We received an %s ACME challenge for %s from Let's Encrypt. Path: %s - <br/>\n%s",
	'msg_acme_success' => 'Your TLS certificate has been successfully generated and saved to folder %s. - Cert: %s | Chain: %s.',

];
