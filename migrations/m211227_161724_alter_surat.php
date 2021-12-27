<?php

use yii\db\Migration;

/**
 * Class m211227_161724_alter_surat
 */
class m211227_161724_alter_surat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('surat_masuk', 'id_satuan_kerja', $this->integer()->notNull());
        $this->addForeignKey('fk-surat_masuk-id_satuan_kerja', 'surat_masuk', 'id_satuan_kerja', 'tb_m_satuan_kerja', 'id_satuan_kerja', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211227_161724_alter_surat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211227_161724_alter_surat cannot be reverted.\n";

        return false;
    }
    */
}
