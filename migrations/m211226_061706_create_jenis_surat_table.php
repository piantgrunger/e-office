<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jenis_surat}}`.
 */
class m211226_061706_create_jenis_surat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%jenis_surat}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(100)->notNull(),
            'keterangan' => $this->text()->notNull(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%jenis_surat}}');
    }
}
