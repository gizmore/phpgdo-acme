<?php
namespace GDO\ACME\Method;

use GDO\Core\Method;
use GDO\Admin\MethodAdmin;
use GDO\ACME\Module_ACME;

/**
 * @author gizmore
 * @version 7.0.2
 */
final class Admin extends Method
{
	use MethodAdmin;
	
	public function onRenderTabs(): void
	{
		$this->renderAdminBar();
		Module_ACME::instance()->renderACMEBar();
	}
	
	public function execute()
	{
	}

}
