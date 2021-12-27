<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%disposisi}}`.
 */
class m211227_165825_create_disposisi_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%disposisi}}', [
            'id' => $this->primaryKey(),
            'id_surat_masuk' => $this->integer()->notNull(),
            'id_jabatan' => $this->integer()->notNull(),
            'id_user' => $this->integer(),
            
            'tanggal_disposisi' => $this->dateTime()->notNull(),
            'status_disposisi' => $this->string(255)->notNull(),
            'catatan_disposisi' => $this->text()->notNull(),
            'tanggal_diterima' => $this->dateTime(),
            'jawaban_disposisi' => $this->text(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%disposisi}}');
    }
}
