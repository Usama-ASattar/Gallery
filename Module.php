<?php

namespace VittITServices\humhub\modules\gallery;

use Yii;
use yii\helpers\Url;
use humhub\modules\space\models\Space;
use VittITServices\humhub\modules\gallery\permissions\ManageGallery;

class Module extends \humhub\components\Module
{
    /**
     * @inheritdoc
     */
    public $resourcesPath = 'resources';

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/gallery/admin']);
    }

    /**
     * @inheritdoc
     */
    public function disable()
    {
        // Cleanup all module data, don't remove the parent::disable()!!!
        parent::disable();
    }

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer instanceof Space) {
            return [
                new ManageGallery(),
            ];
        }

        return [];
    }
}
