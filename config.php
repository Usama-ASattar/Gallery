<?php

use VittITServices\humhub\modules\gallery\Events;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\widgets\TopMenu;
use humhub\components\Widget;
use humhub\components\ModuleManager;
use humhub\modules\space\modules\manage\widgets\DefaultMenu;
use humhub\modules\stream\widgets\StreamViewer;

return [
	'id' => 'gallery',
	'class' => 'VittITServices\humhub\modules\gallery\Module',
	'namespace' => 'VittITServices\humhub\modules\gallery',
	'events' => [
		[
			'class' => ModuleManager::class,
			'event' => ModuleManager::EVENT_AFTER_MODULE_ENABLE,
			'callback' => [Events::class, 'afterModuleEnabled']
		],
		[
			'class' => DefaultMenu::class,
			'event' => DefaultMenu::EVENT_INIT,
			'callback' => [Events::class, 'onSpaceSettingsInit']
		],
		[
			'class' => TopMenu::class,
			'event' => TopMenu::EVENT_INIT,
			'callback' => [Events::class, 'onTopMenuInit'],
		],
		[
			'class' => AdminMenu::class,
			'event' => AdminMenu::EVENT_INIT,
			'callback' => [Events::class, 'onAdminMenuInit']
		],
		[
			'class' => StreamViewer::class,
			'event' => Widget::EVENT_BEFORE_RUN,
			'callback' => [Events::class, 'onCreateWallEntry']
		],
	],
];
