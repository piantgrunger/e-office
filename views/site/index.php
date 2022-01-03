<?php
$pegawai = Yii::$app->user->identity->pegawai;

/* @var $this yii\web\View */


?>
<div class="site-index">

<?php if ($pegawai) { ?>

    <div class="page-body">
                                        <!--profile cover start-->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="cover-profile">
                                                    <div class="profile-bg-img">
                                                        <img class="profile-bg-img img-fluid" src="libraries\assets\images\user-profile\bg-img1.jpg" alt="bg-img">
                                                        <div class="card-block user-info">
                                                            <div class="col-md-12">
                                                                <div class="media-left">
                                                                    <a href="#" class="profile-image">
                                                                        <img class="user-img img-radius" src="https://banjarbaru-bagawi.id/media/<?=$pegawai->foto?>" width="100px" height="100px" alt="user-img">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body row">
                                                                    <div class="col-lg-12">
                                                                        <div class="user-title">
                                                                            <h2><?=$pegawai->nama_lengkap?></h2>
                                                                            <span class="text-white"><?=$pegawai->nama_jabatan?> - <?=$pegawai->nama_satuan_kerja?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                
    </div>


<?php } ?>
</div>
