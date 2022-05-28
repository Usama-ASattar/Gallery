<?php

use humhub\modules\space\models\Space;
use VittITServices\humhub\modules\gallery\views\space\SpaceInfoCard;

// Register our module assets, this could also be done within the controller
\VittITServices\humhub\modules\gallery\assets\Assets::register($this);

/* @var $this View */
/* @var $gallery CommunityDirectoryQuery */

$displayName = (Yii::$app->user->isGuest) ? Yii::t('GalleryModule.base', 'Guest') : Yii::$app->user->getIdentity()->displayName;

// Add some configuration to our js module
$this->registerJsConfig("gallery", [
    'username' => (Yii::$app->user->isGuest) ? $displayName : Yii::$app->user->getIdentity()->username,
    'text' => [
        'hello' => Yii::t('GalleryModule.base', 'Hi there {name}!', ["name" => $displayName])
    ]
])
?>

<div class="row cards">
    <?php if (!$gallery->exists()): ?>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <strong><?= Yii::t('GalleryModule.base', 'No post found!'); ?></strong><br/>
                <?= Yii::t('GalleryModule.base', 'Post new image/video to get into the gallery.'); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php foreach ($gallery->all() as $photo) : ?>
                <div class="row-item-body">
                <li role="separator" class="divider"><strong class="row-item-title"><?= "$photo->alias_name Community"; ?></strong></li>
                    <div class="col-md-12">
                        <?php if ($photo->child_id != "") : ?>
                            <?= SpaceInfoCard::widget(['space' => Space::findOne(['guid' => $photo->child_id])]); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="divider"><br></br></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
