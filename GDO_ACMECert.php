<?php
namespace GDO\ACME;

use GDO\Core\GDO;
use GDO\Net\GDT_Domain;

/**
 * Store config in DB.
 * Generate config file maybe.
 * 
 * @author gizmore
 * @version 7.0.2
 */
final class GDO_ACMECert extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_Domain::
			
		];
	}
	
}
