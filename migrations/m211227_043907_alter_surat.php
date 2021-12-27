<?php

use yii\db\Migration;

/**
 * Class m211227_043907_alter_surat
 */
class m211227_043907_alter_surat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('surat_masuk', 'tgl_terima', $this->dateTime()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211227_043907_alter_surat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211227_043907_alter_surat cannot be reverted.\n";

        return false;
    }
    */
}
