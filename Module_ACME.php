<?php
namespace GDO\ACME;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Page;
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;
use GDO\Core\WithComposer;

/**
 * ACME/LetsEncrypt utility module.
 * 
 * @author gizmore
 * @version 7.0.2
 * @since 7.0.2;
 */
final class Module_ACME extends GDO_Module
{
	
	use WithComposer;
	
	public int $priority = 80;
	public string $license = '';
	
	public function getClasses(): array
	{
		return [
			GDO_ACMECert::class,
		];		
	}
	
	##############
	### Config ###
	##############
	public function href_administrate_module(): ?string
	{
		return href('ACME', 'Admin');
	}
	
	############
	### Init ###
	############
	public function onLoadLanguage(): void
	{
		$this->loadLanguage('lang/acme.sh');
	}
	
	/**
	 * Add ACME bar to tabs.
	 */
	public function renderACMEBar(): void
	{
		$bar = GDT_Bar::make('acmebar')->horizontal();
		$bar->addFields(
			GDT_Link::make('acme_link_issue')->href(href('ACME', 'Issue')),
			GDT_Link::make('acme_link_renew')->href(href('ACME', 'Renew')),
			);
		GDT_Page::instance()->topResponse()->addField($bar);
	}
	
}
