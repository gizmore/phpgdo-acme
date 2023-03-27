<?php
namespace GDO\ACME\Method;

use GDO\ACME\Module_ACME;
use GDO\Admin\MethodAdmin;
use GDO\Core\GDT;
use GDO\Core\GDT_Response;
use GDO\Core\Method;

/**
 * Administration.
 *
 * @version 7.0.2
 * @author gizmore
 */
final class Admin extends Method
{

	use MethodAdmin;

	public function onRenderTabs(): void
	{
		$this->renderAdminBar();
		Module_ACME::instance()->renderACMEBar();
	}

	public function execute(): GDT
	{
		return GDT_Response::make();
	}

}
