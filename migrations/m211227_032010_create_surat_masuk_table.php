<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%surat_masuk}}`.
 */
class m211227_032010_create_surat_masuk_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%surat_masuk}}', [
            'id' => $this->primaryKey(),
            'nomor_surat' => $this->string(100)->notNull(),
            'id_jenis_surat' => $this->integer()->notNull(),
            'sifat' => $this->string(100)->notNull(),
            'tgl_surat' => $this->date()->notNull(),
            'tgl_terima' => $this->date()->notNull(),
            'asal_surat' => $this->string(100)->notNull(),
            'perihal' => $this->string(100)->notNull(),
            'file_surat' => $this->string(100),

        ]);
        $this->addForeignKey('fk-surat_masuk-jenis_surat', 'surat_masuk', 'id_jenis_surat', 'jenis_surat', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%surat_masuk}}');
    }
}
