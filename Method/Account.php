<?php
namespace GDO\ACME\Method;

use GDO\ACME\Module_ACME;
use GDO\Admin\MethodAdmin;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\Util\FileUtil;
use stonemax\acme2\Client;

/**
 * Renew certificates.
 *
 * @version 7.0.2
 * @author gizmore
 */
final class Account extends MethodForm
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
		$client = self::acmeAccount();
		return $this->issueCert($client);
	}

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

}
