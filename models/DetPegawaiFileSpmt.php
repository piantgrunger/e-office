<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tb_d_pegawai_file".
 *
 * @property int $id_d_pangkat
 * @property string $jenis
 * @property string $uraian1
 * @property string $uraian2
 * @property int $id_pegawai
 * @property string $tanggal1
 * @property string $tanggal2
 * @property int $id_jabatan
 * @property int $id_pangkat
 * @property string $file
 */
class DetPegawaiFileSpmt extends DetPegawaiFile
{
    //
}
