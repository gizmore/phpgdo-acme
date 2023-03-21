<?php
namespace GDO\ACME\Method;

use GDO\ACME\Module_ACME;
use GDO\Admin\MethodAdmin;
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

	public function execute() {}

}
