<?php

use yii\db\Migration;

/**
 * Class m211228_162949_alter_table_surat
 */
class m211228_162949_alter_table_surat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('surat_masuk', 'id_pengirim', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211228_162949_alter_table_surat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211228_162949_alter_table_surat cannot be reverted.\n";

        return false;
    }
    */
}
