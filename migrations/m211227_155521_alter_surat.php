<?php

use yii\db\Migration;

/**
 * Class m211227_155521_alter_surat
 */
class m211227_155521_alter_surat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //$this->dropColumn('surat_masuk', 'perihal');
        $this->addColumn('surat_masuk', 'perihal', $this->text()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211227_155521_alter_surat cannot be reverted.\n";

        return false;
    }
    */
}
