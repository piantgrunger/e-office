<?php

use yii\db\Migration;

/**
 * Class m200119_032851_create_account
 */
class m200119_032851_create_account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('Akun', [
          'id' =>$this->primaryKey(),
          'parent_id' => $this->integer()->notNull()->defaultValue(0),
          'level' => $this->integer()->notNull()->defaultValue(1),
          'kode' => $this->string(10)->notNull(),
          'nama' => $this->string(100)->notNull(),
          'd_k' => $this->string(1)->notNull(),
          'm_d' => $this->string(1),
          'kelompok' => $this->string(100)->notNull(),


      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('akun');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200119_032851_create_account cannot be reverted.\n";

        return false;
    }
    */
}
