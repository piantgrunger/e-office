<?php
namespace app\jobs;

use Yii;
use yii\queue\JobInterface;
use yii\base\BaseObject;
use app\models\Disposisi;
use GuzzleHttp\Client;

class SendWhatsAppJob extends BaseObject implements JobInterface
{
    public $id;

    public function execute($queue)
    {
        $disposisi = Disposisi::find()->where(['id'=>$this->id])->one();
         
        try {
        
           
           
   //    shell_exec("pm2 reload app");
            $client = new Client();
        } catch (Exception  $e) {
        }
    }
}
