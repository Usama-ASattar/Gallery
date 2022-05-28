<?php

namespace VittITServices\humhub\modules\gallery\controllers;

use humhub\components\Controller;
use VittITServices\humhub\modules\gallery\components\CommunityDirectoryQuery;
use VittITServices\humhub\modules\gallery\models\Community;
use VittITServices\humhub\modules\gallery\models\forms\SpaceSettingsForm;

class IndexController extends Controller
{

    public $subLayout = "@gallery/views/layouts/default";

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        $commDirectoryQuery = new CommunityDirectoryQuery();
    
        // return $this->render('index');

        return $this->render('index', ['gallery' => $commDirectoryQuery,]);
    }

}

