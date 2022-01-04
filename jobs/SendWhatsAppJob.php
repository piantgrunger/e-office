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
            $pegawai = $disposisi->pegawai;
            $recipient = $pegawai->telepon;
            $pesan ="📝 *Notifikasi Disposisi Surat Masuk*\n\nSaudara/i ".$pegawai->nama_lengkap.", saat ini terdapat  surat masuk  ".Url::to(['/document/'.$disposisi->suratMasuk->file_surat], true)."
             yang di disposisikan kepada PIan dengan catatan : ".$disposisi->catatan_disposisi."\n\nSilahkan login ke aplikasi untuk melihat detail surat masuk.\n\nTerima Kasih.";

            
        
           
           
            //    shell_exec("pm2 reload app");
            $data = [
                'number' => $recipient.'@c.us',
                'message' => $pesan,
                ];
      
            $client = new Client();

            $client->request("POST", Yii::$app->params['urlSendWA'], [
                  'form_params' => $data,
                ]);
        } catch (Exception  $e) {
        }
    }
}
