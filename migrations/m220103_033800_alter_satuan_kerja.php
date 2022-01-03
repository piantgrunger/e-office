<?php

use yii\db\Migration;

/**
 * Class m220103_033800_alter_satuan_kerja
 */
class m220103_033800_alter_satuan_kerja extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tb_m_satuan_kerja', 'status_eoffice', $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220103_033800_alter_satuan_kerja cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220103_033800_alter_satuan_kerja cannot be reverted.\n";

        return false;
    }
    */
}
