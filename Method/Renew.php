<?php
namespace GDO\ACME\Method;

use GDO\ACME\Module_ACME;
use GDO\Admin\MethodAdmin;
use GDO\Core\GDT;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;

/**
 * Renew certificates.
 *
 * @version 7.0.2
 * @author gizmore
 */
final class Renew extends MethodForm
{

	use MethodAdmin;

    public function isCLI(): bool { return true; }

    public function onRenderTabs(): void
	{
		$this->renderAdminBar();
		Module_ACME::instance()->renderACMEBar();
	}

	protected function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form): GDT {}

}
