<?php

use yii\db\Migration;

/**
 * Class m210623_192043_gallery_initial
 */
class m210623_192043_gallery_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('gallery_photo', [
            'id' => $this->primaryKey(),
            'child_id' => 'varchar(45) DEFAULT NULL',
            'parent_id' => 'varchar(45) DEFAULT NULL',
            'alias_name' => 'varchar(200) DEFAULT NULL',
        ], '');

        // creates index for column `child_id`
        $this->createIndex(
            'idx-photo-child_id',
            'gallery_photo',
            'child_id'
        );

        // add foreign key for table `space`
        // $this->addForeignKey(
        //     'fk-photo-child_id',
        //     'gallery_photo',
        //     'child_id',
        //     'space',
        //     'guid',
        //     'CASCADE'
        // );

        // creates index for column `parent_id`
        $this->createIndex(
            'idx-photo-parent_id',
            'gallery_photo',
            'parent_id'
        );

        // add foreign key for table `space`
        // $this->addForeignKey(
        //     'fk-photo-parent_id',
        //     'gallery_photo',
        //     'parent_id',
        //     'space',
        //     'guid',
        //     'CASCADE'
        // );

        // creates index for column `alias_name`
        $this->createIndex(
            'idx-photo-alias_name',
            'gallery_photo',
            'alias_name'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210623_191041_gallery_inital cannot be reverted.\n";
        $this->dropTable('gallery_photo');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210623_192043_gallery_initial cannot be reverted.\n";

        return false;
    }
    */
}
