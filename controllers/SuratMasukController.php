<?php

namespace app\controllers;

use app\models\Disposisi;
use app\models\DisposisiDetail;
use Yii;
use app\models\SuratMasuk;
use app\models\DisposisiSearch;

use app\models\SuratMasukSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SuratMasukController implements the CRUD actions for SuratMasuk model.
 */
class SuratMasukController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SuratMasuk models.
     * @return mixed
     */

    public function actionIndexDisposisi()
    {
        $searchModel = new DisposisiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        return $this->render('index-disposisi', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionIndex()
    {
        $searchModel = new SuratMasukSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SuratMasuk model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionDisposisi($id)
    {
        if (Yii::$app->user->identity->pegawai) {
            $id_pegawai = Yii::$app->user->identity->pegawai->id_pegawai;
            $model = Disposisi::find()->where(['id_surat_masuk'=>$id, 'id_pegawai'=>$id_pegawai])->one();
            if ($model && $model->status_disposisi == 'Belum Diterima') {
                $model->status_disposisi = 'Sudah Dibaca';
                $model->save(false);
            }
        }
        return $this->render('disposisi', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreateDisposisi($id_disposisi, $id_surat_masuk)
    {
        $model = new Disposisi();

        if ($model->load(Yii::$app->request->post())) {
            $disposisiDetails = Yii::$app->request->post('DisposisiDetail');
            foreach ($disposisiDetails as $key => $disposisiDetail) {
                $modelDisposisiDetail = new Disposisi();
                $modelDisposisiDetail->id_surat_masuk = $id_surat_masuk;
                $modelDisposisiDetail->id_parent = $id_disposisi;
                $modelDisposisiDetail->catatan_disposisi = $model->catatan_disposisi;
                $modelDisposisiDetail->tanggal_disposisi = date('Y-m-d');
                $modelDisposisiDetail->status_disposisi = 'Belum Diterima';
          

                $modelDisposisiDetail->id_pegawai = $disposisiDetail['id_pegawai'];
                $modelDisposisiDetail->save(false);
            }
            $model = Disposisi::find()->where([ 'id'=>$id_disposisi])->one();
            $model->status_disposisi = 'Di Disposisikan';
            $model->save(false);
            return $this->redirect(['disposisi','id'=>$id_surat_masuk]);
        }
        return $this->render('create-disposisi', [
            'model' => $model,
            'id_disposisi' => $id_disposisi,
            'id_surat_masuk' => $id_surat_masuk,
           'disposisiDetails' => [new DisposisiDetail()],
        ]);
    }
    public function actionCreateDisposisiLangsung($id)
    {
        $model = new Disposisi();

        if ($model->load(Yii::$app->request->post())) {
            $disposisiDetails = Yii::$app->request->post('DisposisiDetail');
            foreach ($disposisiDetails as $key => $disposisiDetail) {
                $modelDisposisiDetail = new Disposisi();
                $modelDisposisiDetail->id_surat_masuk = $id;
                //$modelDisposisiDetail->id_parent = $id_disposisi;
                $modelDisposisiDetail->catatan_disposisi = $model->catatan_disposisi;
                $modelDisposisiDetail->tanggal_disposisi = date('Y-m-d');
                $modelDisposisiDetail->status_disposisi = 'Belum Diterima';
          

                $modelDisposisiDetail->id_pegawai = $disposisiDetail['id_pegawai'];
                $modelDisposisiDetail->save(false);
            }
   
            return $this->redirect(['index']);
        }
        return $this->render('create-disposisi', [
            'model' => $model,
            //'id_disposisi' => $id_disposisi,
            'id_surat_masuk' => $id,
           'disposisiDetails' => [new DisposisiDetail()],
        ]);
    }

    public function actionJawabDisposisi($id)
    {
        $model = Disposisi::find()->where(['id'=>$id])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->status_disposisi = 'Sudah Dikerjakan';
            $model->save(false);
            return $this->redirect(['disposisi','id'=>$model->id_surat_masuk]);
        }
        return $this->render('jawab-disposisi', [
            'model' => $model,
        ]);
    }
    /**
     * Creates a new SuratMasuk model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SuratMasuk();
        $model->saveOld();

        if ($model->load(Yii::$app->request->post())) {
            $no_agenda = SuratMasuk::find()->where(['id_satuan_kerja'=>$model->id_satuan_kerja])->max('no_agenda');
            $model->no_agenda = $no_agenda + 1;
            $model->tgl_terima = date('Y-m-d H:i:s');
            if ($model->save()) {

                /** Disposisi ke pimpinan SKPD */
                $disposisi =  new  Disposisi();
                $disposisi->id_surat_masuk = $model->id;
                $disposisi->id_pegawai = $model->satuanKerja->personPimpinan->id_pegawai;
                $disposisi->tanggal_disposisi = date('Y-m-d');
                $disposisi->status_disposisi = 'Belum Diterima';
                $disposisi->catatan_disposisi = 'Surat masuk dari '.$model->pengirim_surat ." Tanggal ". Yii::$app->formatter->asDate($model->tgl_surat);
                $disposisi->save(false);


                return $this->redirect(['index']);
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            if (Yii::$app->user->identity->pegawai) {
                $model->id_satuan_kerja = Yii::$app->user->identity->pegawai->id_satuan_kerja;
            } else {
                $model->id_satuan_kerja = Yii::$app->user->identity->id_satuan_kerja;
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SuratMasuk model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->saveOld();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SuratMasuk model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (\yii\db\IntegrityException  $e) {
            Yii::$app->session->setFlash('error', "Data Tidak Dapat Dihapus Karena Dipakai Modul Lain");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the SuratMasuk model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SuratMasuk the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SuratMasuk::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteDisposisi($id)
    {
        if (($model = Disposisi::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $id_surat_masuk = $model->id_surat_masuk;
        try {
            $model->delete();
        } catch (\yii\db\IntegrityException  $e) {
            Yii::$app->session->setFlash('error', "Data Tidak Dapat Dihapus Karena Dipakai Modul Lain");
        }
        return $this->redirect(['disposisi','id'=>$id_surat_masuk]);
    }
}
