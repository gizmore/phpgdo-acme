<?php
namespace GDO\ACME\Method;

use GDO\Admin\MethodAdmin;
use GDO\ACME\Module_ACME;
use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use stonemax\acme2\constants\CommonConstant;
use GDO\Core\GDO_ErrorFatal;
use GDO\Core\GDT;
use GDO\Net\GDT_Domain;
use GDO\Net\GDT_DomainName;
use GDO\Core\Website;

/**
 * Issue TLS certificates.
 * 
 * @author gizmore
 * @version 7.0.2
 */
final class Issue extends MethodForm
{
	use MethodAdmin;
	
	public function onRenderTabs(): void
	{
		$this->renderAdminBar();
		Module_ACME::instance()->renderACMEBar();
	}
	
	public function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form)
	{
		return $this->issueCert(Module_ACME::instance(), GDO_DOMAIN);
	}

	public function issueCert(Module_ACME $module, string $domain)
	{
		$domain = 'phpgdo.com';
		
		$gdt = $this->checkDomain($domain);
		
		if ($gdt->hasError())
		{
			return $this->error('err_acme_domain', [$gdt->renderError()]);
		}
		
		$module->includeVendor();
		$client = Account::acmeAccount();
		$domainInfo = [
			CommonConstant::CHALLENGE_TYPE_HTTP => [
				$domain,
			],
		];
		$time = $module->cfgChallengeTime();
		$order = $client->getOrder($domainInfo, $module->cfgCryptoConst(), true);
		$challengeList = $order->getPendingChallengeList();
		foreach ($challengeList as $challenge)
		{
			$credential = $challenge->getCredential();
			if ($this->isHTTPChallenge($challenge))
			{
				$this->challengeHTTP($module, $credential);
			}
			else
			{
				$this->challengeDNS($module, $credential);
			}
// 			$challengeType = $challenge->getType();
			
// 			echo $challengeType."\n";
// 			print_r($credential);
			
// 			{
// 				$this->challengeHTTP($module, $credential);
// 			}
// 			elseif ($challengeType == CommonConstant::CHALLENGE_TYPE_DNS)
// 			{
// 				$this->challengeDNS($module, $credential);
// 			}
		}
		foreach ($challengeList as $challenge)
		{
			$challenge->verify($time, $time);
		}
		$certificateInfo = $order->getCertificateFile();
		print_r($certificateInfo);
		Website::error('ACME', 'err_acme_challenge', [t('err_timeout', [$time])]);
		return $this->saveCertificate($certificateInfo);
	}
	
	private function checkDomain(string $domain): ?GDT_DomainName
	{
		$gdt = GDT_DomainName::make('domain')->
			initial($domain)->tldOnly();
		$gdt->validate($gdt->toValue($domain));
		return $gdt;
	}
	
	private function isHTTPChallenge($challenge): bool
	{
		return $challenge->getType() === CommonConstant::CHALLENGE_TYPE_HTTP;
	}
	
	private function challengeHTTP(Module_ACME $module, array $credential): bool
	{
		$domain = $credential['identifier'];
		$filename = $credential['fileName'];
		$contents = $credential['fileContent'];
		$folder = $module->cfgStoragePath();
		$path = $folder . $filename;
		if (false === file_put_contents($path, $contents))
		{
			$this->error('err_acme_challenge', [t('err_write_file', [$path])]);
			return false;
		}
		$this->message('msg_acme_challenge', [
			'HTTP', $domain, html($path), html($contents)]);
		return true;
	}
	
	private function challengeDNS(Module_ACME $module, array $credential): void
	{
// 		$domain = $credential['identifier'];
// 		$contents = $credential['dnsContent'];
		throw new GDO_ErrorFatal('err_acme_dns');
	}

	private function saveCertificate(array $info)
	{
		print_r($info);
		return $this->message('msg_acme_success', [GDO_DOMAIN, $pathCert, $pathChain]);
	}
	
}
