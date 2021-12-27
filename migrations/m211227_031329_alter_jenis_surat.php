<?php

use yii\db\Migration;

/**
 * Class m211227_031329_alter_jenis_surat
 */
class m211227_031329_alter_jenis_surat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('jenis_surat', 'keterangan', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211227_031329_alter_jenis_surat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211227_031329_alter_jenis_surat cannot be reverted.\n";

        return false;
    }
    */
}
