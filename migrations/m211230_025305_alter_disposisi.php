<?php

use yii\db\Migration;

/**
 * Class m211230_025305_alter_disposisi
 */
class m211230_025305_alter_disposisi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('disposisi', 'id_parent', $this->integer());
        $this->dropColumn('disposisi', 'id_user');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211230_025305_alter_disposisi cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211230_025305_alter_disposisi cannot be reverted.\n";

        return false;
    }
    */
}
