<?php
namespace GDO\ACME\Method;

use GDO\Cronjob\MethodCronjob;

/**
 * Renew certs automatically.
 *
 * @version 7.0.2
 * @author gizmore
 */
final class Cronjob extends MethodCronjob
{

	public function runAt()
	{
		return $this->runDailyAt(5);
	}

	public function run()
	{
		$result = Renew::make()->executeWithInputs([
			'submit' => 1], false);
		$this->logNotice($result->renderCLI());
	}

}
