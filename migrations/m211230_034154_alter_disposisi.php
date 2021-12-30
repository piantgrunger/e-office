<?php

use yii\db\Migration;

/**
 * Class m211230_034154_alter_disposisi
 */
class m211230_034154_alter_disposisi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_disposisi_surat_masuk', 'disposisi', 'id_surat_masuk', 'surat_masuk', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211230_034154_alter_disposisi cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211230_034154_alter_disposisi cannot be reverted.\n";

        return false;
    }
    */
}
