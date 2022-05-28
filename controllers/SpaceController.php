<?php

namespace VittITServices\humhub\modules\gallery\controllers;

use Yii;
use humhub\components\Controller;
use humhub\modules\content\widgets\richtext\RichText;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\space\models\Space;
use VittITServices\humhub\modules\gallery\models\forms\SpaceSettingsForm;
use  VittITServices\humhub\modules\gallery\components\GalleryContentContainerStream;
use VittITServices\humhub\modules\gallery\components\CommunityDirectoryQuery;

class SpaceController extends ContentContainerController
{

    public function init()
    {
        parent::init();

        if ($this->contentContainer instanceof Space) {
            $this->subLayout = "@humhub/modules/space/views/space/_layout";
        }
    }

    public function actions()
    {
        return [
            'photostream' => [
                'class' => GalleryContentContainerStream::class,
                'contentContainerIds' => isset($_GET["ids"]) ? $_GET["ids"] : ""
            ]
        ];
    }

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        $commDirectoryQuery = new CommunityDirectoryQuery();
        $form = new SpaceSettingsForm($this->contentContainer->guid);

        if ($form->load(Yii::$app->request->post()) && $form->validate() && $form->save()) {
            $this->view->saved();
            return $this->redirect(['settings']);
        }

        return $this->render('index', ['contentContainer' => $this->contentContainer, 'model' => $form, 'gallery' => $commDirectoryQuery,]);
    }
}
