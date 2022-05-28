<?php

namespace VittITServices\humhub\modules\gallery;

use Yii;
use yii\base\Event;
use yii\helpers\Url;
use humhub\modules\space\models\Space;
use humhub\modules\ui\menu\MenuLink;
use humhub\modules\stream\widgets\StreamViewer;
use VittITServices\humhub\modules\gallery\models\Community;
use VittITServices\humhub\modules\gallery\helpers\Url as urlManager;

class Events
{

    /**
     * Defines what to do when the module is enabled.
     *
     * @param $event
     */
    public static function afterModuleEnabled($event)
    {
    }

    /**
     * Defines what to do when the space settings page is called.
     *
     * @param $event
     */
    public static function onSpaceSettingsInit(Event $event)
    {

        // $space = $event->sender->space;

        // if ($space->isAdmin()) {
        //     $event->sender->addItem([
        //         'label' => Yii::t('TopicModule.base', 'Topics'),
        //         'url' => $space->createUrl('/topic/manage'),
        //         'isActive' => MenuLink::isActiveState('topic', 'manage'),
        //         'sortOrder' => 250
        //     ]);
        // }
        if ($event->sender->space->isAdmin()) {
            $event->sender->addItem([
                'label' => Yii::t('GalleryModule.base', 'Gallery'),
                'url' => $event->sender->space->createUrl(urlManager::toSpaceSettings()),
                'sortOrder' => 200,
                'isActive' => MenuLink::isActiveState('gallery', 'space', 'index')
            ]);
        }
    }

    /**
     * Defines what to do when the top menu is initialized.
     *
     * @param $event
     */
    public static function onTopMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'Gallery',
            'icon' => '<i class="fa fa-picture-o"></i>',
            'url' => Url::to(['/gallery/index']),
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'gallery' && Yii::$app->controller->id == 'index'),
        ]);
    }

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'Gallery',
            'url' => Url::to(['/gallery/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-picture-o"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'gallery' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 99999,
        ]);
    }

    /**
     * Defines what to do if the gallery-tabs in space settings is selected.
     *
     * @param $event
     */
    public static function onSpaceCommunitySettingsTab(Event $event)
    {
        if ($event->sender->space !== null) {
            /** @var Menu $sender */
            // $sender = $event->sender;
            // if (!($sender instanceof Menu)) {
            //     throw new \LogicException();
            // }

            /** @var Space $space */
            $space = $sender->space;
            if (!($space instanceof Space)) {
                throw new \LogicException();
            }
            // $event->sender->addItem([
            //     'label' => 'Paper Input',
            //     'group' => 'modules',
            //     'icon' => '<i class="fa fa-book"></i>',
            //     'url' => $space->createUrl(urlManager::toSpaceFromMenu()),
            //     'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'daveandpeterspaperscheduleinput'),
            // ]);

            $event->sender->addItem([
                'label' => 'Gallery',
                'url' => $space->createUrl(urlManager::toSpaceSettings()),
                'group' => 'manage',
                'icon' => '<i class="fa fa-picture-o"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'gallery' && Yii::$app->controller->id == 'admin'),
                'sortOrder' => 99999,
            ]);
        }
    }

    /**
     * Defines what to do when a task is displayed on the wall.
     *
     * @param $event of type yii\base\WidgetEvent
     */
    public static function onCreateWallEntry($event)
    {
        if ((get_class($event->sender) != StreamViewer::class) || is_null($event->sender->contentContainer) || (get_class($event->sender->contentContainer) != Space::class)) {
            return $event;
        }

        // Check if contentcontainerid has children in gallery db-table
        $contentcontainerids = [];
        $gallery = Community::findAll(['parent_id' => $event->sender->contentContainer->guid]);
        if (count($gallery) > 0) {
            foreach ($gallery as $photo) {
                // If so integrate events from children in stream
                array_push($contentcontainerids, $photo->child_id);
            }
            $event->sender->streamActionParams["ids"] = $contentcontainerids;
            $event->sender->streamAction = urlManager::toModifiedStreamAction();
        }

        return $event;
    }
}
