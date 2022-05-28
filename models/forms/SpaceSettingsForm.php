<?php

namespace VittITServices\humhub\modules\gallery\models\forms;

use VittITServices\humhub\modules\gallery\models\Community;
use humhub\modules\space\models\Space;
use yii\base\Model;
use Yii;

class SpaceSettingsForm extends Model
{

    public $galleryGuid = [];
    public $gallery = [];
    public $spaces = [];

    private $contentContainerId;

    public function __construct($contentContainerId)
    {
        $this->contentContainerId = $contentContainerId;
        $this->gallery = Community::findAll(['child_id' => $this->contentContainerId]);
        foreach ($this->gallery as $photo) {
            //Get the space-object to make the picker work.
            $this->findspaces($photo);
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
    }

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            ['galleryGuid', 'checkSpaceGuid'],
            // [['child_id'], 'required', 'string', 'max' => 45, 'min' => 2],
            // [['parent_id'], 'required', 'string', 'max' => 45, 'min' => 2],
        ];
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return [
            'galleryGuid' => Yii::t('GalleryModule.space', 'Community'),
        ];
    }

    /**
     * This validator function checks the galleryGuid.
     * @param type $attribute
     * @param type $params
     */
    public function checkSpaceGuid($attribute, $params)
    {
        // $this->spaces = Space::find()->where(['not in', 'guid', $contentContainerId])->all();
        if (!empty($this->galleryGuid)) {
            foreach ($this->galleryGuid as $spaceGuid) {
                if ($spaceGuid != "") {
                    $space = \humhub\modules\space\models\Space::findOne(['guid' => $spaceGuid]);
                    if ($space == null) {
                        $this->addError($attribute, Yii::t('GalleryModule.space', "Invalid space"));
                    }
                }
            }
        }
    }

    public function save()
    {
        // $photo = Community::findOne(['child_id' => $this->contentContainerId, 'parent_id' => $galleryguid]);
        // Remove all instances to populate it afterwards with the selected spaces.
        Community::deleteAll(['child_id' => $this->contentContainerId]);
        $this->spaces = [];
        if (!empty($this->galleryGuid)) {
            foreach ($this->galleryGuid as $galleryguid) {
                // Do not add the space to itself.
                if (($galleryguid != $this->contentContainerId) && $this->validate()) {
                    // Add new Community
                    $photo = new Community();
                    $photo->child_id = $this->contentContainerId;
                    $photo->parent_id = $galleryguid;

                    $space = \humhub\modules\space\models\Space::findOne(['guid' => $galleryguid]);
                    $photo->alias_name = $space->name;

                    $photo->save();
                    $this->findspaces($photo);
                }
            }
        }
    }

    private function findspaces($photo)
    {
        $space = Space::findOne(['guid' => $photo->parent_id]);
        if (!is_null($space)) {
            array_push($this->spaces, $space);
        }
    }
}
