<?php
namespace GDO\ACME;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Page;
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;
use GDO\Core\WithComposer;
use GDO\Mail\GDT_Email;
use GDO\Core\GDT_Checkbox;
use GDO\Core\GDT_EnumNoI18n;
use GDO\Date\GDT_Duration;
use stonemax\acme2\constants\CommonConstant;

/**
 * ACME, Webserver and Lets Encrypt utility.
 * 
 * @author gizmore
 * @version 7.0.2
 * @since 7.0.2;
 */
final class Module_ACME extends GDO_Module
{
	use WithComposer;
	
	##############
	### Module ###
	##############
	public int $priority = 95;
	public string $license = 'MIT';
	
	##############
	### Config ###
	##############
	public function getDependencies(): array
	{
		return [
			'Net',
		];
	}
	
	public function href_administrate_module(): ?string
	{
		return href('ACME', 'Admin');
	}
	
	public function getConfig(): array
	{
		return [
			GDT_Email::make('acme_account_email')->notNull()->initial(GDO_ADMIN_EMAIL),
			GDT_Checkbox::make('acme_staging_mode')->notNull()->initial('0'),
			GDT_Duration::make('acme_challenge_time')->notNull()->initial('60s'),
			GDT_EnumNoI18n::make('acme_algorithm')->enumValues('EC', 'RSA')->notNull()->initial('EC'),
		];
	}
	public function cfgStagingMode(): bool { return $this->getConfigValue('acme_staging_mode'); }
	public function cfgAccountEmail(): string { return $this->getConfigVar('acme_account_email'); }
	public function cfgCryptoAlgo(): string { return $this->getConfigVar('acme_algorithm'); }
	public function cfgChallengeTime(): int { return $this->getConfigValue('acme_challenge_time'); }
	public function cfgCryptoConst()
	{
		return $this->cfgCryptoAlgo() === 'EC' ?
			CommonConstant::KEY_PAIR_TYPE_EC :
			CommonConstant::KEY_PAIR_TYPE_RSA;
	}
	public function cfgStoragePath(): string
	{
		return GDO_PATH . 'protected/acme/' .
			GDO_ENV . '/' . GDO_DOMAIN . '/';
	}
	
	############
	### Init ###
	############
	public function onLoadLanguage(): void
	{
		$this->loadLanguage('lang/acme');
	}

	##############
	### Render ###
	##############
	/**
	 * Add ACME bar to tabs.
	 */
	public function renderACMEBar(): void
	{
		$bar = GDT_Bar::make('acmebar')->horizontal();
		$bar->addFields(
			GDT_Link::make('acme_link_issue')->href(href('ACME', 'Issue')),
			GDT_Link::make('acme_link_renew')->href(href('ACME', 'Renew')));
		GDT_Page::instance()->topResponse()->addField($bar);
	}
	
}
