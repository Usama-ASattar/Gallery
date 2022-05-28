<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace VittITServices\humhub\modules\gallery\components;

use VittITServices\humhub\modules\gallery\components\ActiveQueryCommunity;
use humhub\modules\space\models\Space;
use VittITServices\humhub\modules\gallery\models\Community;
use Yii;
use yii\data\Pagination;

/**
 * CommunityDirectoryQuery is used to query Community records on the Gallery page.
 *
 * @author luke
 */
class CommunityDirectoryQuery extends ActiveQueryCommunity
{

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct(Community::class, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->visible();
    }

}
