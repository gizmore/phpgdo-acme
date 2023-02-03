<?php
namespace GDO\ACME\Method;

use GDO\Cronjob\MethodCronjob;

/**
 * Run the renewal once daily.
 * 
 * @author gizmore
 * @version 7.0.2
 */
final class Cronjob extends MethodCronjob
{
	public function runAt()
	{
		return $this->runDailyAt(5);
	}
	
	public function run()
	{
		$this->renew();
	}
	
	private function renew(): void
	{
	}
	
}
