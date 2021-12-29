<?php

use yii\db\Migration;

/**
 * Class m211229_043837_alter_disposisi
 */
class m211229_043837_alter_disposisi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('disposisi', 'id_pegawai', $this->integer()->notNull());
        $this->addForeignKey('fk-disposisi-id_pegawai', 'disposisi', 'id_pegawai', 'tb_m_pegawai', 'id_pegawai', 'CASCADE');
        $this->dropColumn('disposisi', 'id_jabatan');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211229_043837_alter_disposisi cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211229_043837_alter_disposisi cannot be reverted.\n";

        return false;
    }
    */
}
