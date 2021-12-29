<?php

use yii\db\Migration;

/**
 * Class m211229_041023_alter_table_surat
 */
class m211229_041023_alter_table_surat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('surat_masuk', 'status', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211229_041023_alter_table_surat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211229_041023_alter_table_surat cannot be reverted.\n";

        return false;
    }
    */
}
