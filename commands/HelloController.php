<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use Yii;
use app\models\Disposisi;
use GuzzleHttp\Client;
use yii\helpers\Url;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionSend($id)
    {
        $disposisi = Disposisi::find()->where(['id'=>$id])->one();
         
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
