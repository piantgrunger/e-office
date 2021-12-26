<?php

namespace app\models;


class AbsenRedis extends \yii\redis\ActiveRecord
{
    public function attributes()
    {
         return [
            'id',
            'id_pegawai',
            'masuk_kerja', 
            'pulang_kerja',
            'tgl_absen',
           'longitude',
           'latitude',
           
           
         ];
        
        
    }   
  
    public function rule()
    {
         return[ [ [
            'id',
            'id_pegawai',
            'masuk_kerja', 
            'pulang_kerja',
           'tgl_absen',
           
         ] ,'string']
                
                ];
        
        
    }   
  
     public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }

    public function getNama_pegawai()
    {
        return is_null($this->pegawai) ? '' : '' . $this->pegawai->nama_lengkap;
    }

  
  
  
} 