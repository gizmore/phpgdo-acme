<?php
namespace GDO\ACME\Method;

use GDO\Admin\MethodAdmin;
use GDO\ACME\Module_ACME;
use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use stonemax\acme2\Client;
use GDO\Util\FileUtil;

/**
 * Renew certificates.
 *
 * @author gizmore
 * @version 7.0.2
 */
final class Account extends MethodForm
{
	use MethodAdmin;
	
	public static function acmeAccount(): Client
	{
		$mod = Module_ACME::instance();
		$path = $mod->cfgStoragePath();
		FileUtil::createDir($path);
		return new Client(
			[$mod->cfgAccountEmail()],
			$path,
			$mod->cfgStagingMode());
	}
	
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
		$client = self::acmeAccount();
		return $this->issueCert($client);
	}
	
}
