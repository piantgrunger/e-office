<?php
namespace app\models;

use Yii;
use yii\base\Model;

class DisposisiDetail extends Model
{
    public $id_disposisi;
    public $id_pegawai;
    public function rules()
    {
        return [
            [['id_pegawai'], 'required'],
            [['id_disposisi', 'id_pegawai'], 'integer'],
        ];
    }
}
