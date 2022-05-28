<?php

namespace VittITServices\humhub\modules\gallery\components;

use humhub\modules\space\models\Space;
use humhub\modules\stream\actions\ContentContainerStream;

class GalleryContentContainerStream extends ContentContainerStream
{

    /**
     * @var ContentContainerActiveRecord[]
     */
    public $contentContainerIds;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    protected function initQuery($options = [])
    {
        $options['container'] = array();
        foreach ($this->contentContainerIds as $id) {
            $space = Space::findByGuid($id);
            if (!is_null($space)) {
                array_push($options['container'], $space);
            }
        }

        return parent::initQuery($options);
    }
}
