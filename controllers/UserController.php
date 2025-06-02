<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\Product;
//use app\models\Desa;
//use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\imagine\Image;
//use yii\web\UploadedFile;
use app\models\SignupForm;
use app\models\ChangePasswordForm;
use app\models\ProductSearch;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'delete', 'index', 'update', 'view', 'map'],
                'rules' => [
                    [
                        'actions' => ['create', 'delete', 'index', 'map'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['admin', 'member']
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],            
            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionMap()
    {
        $model = User::find()->where(['not', ['user.lat' => null]])->joinWith('idDesa')->all();
            
        $items = [];
        foreach ($model as $nama){
            if ($nama->id_desa == NULL) {
                $nama->id_desa = 999;
            }
            
            $tmp = $nama->getIdDesa()->select(['id_kecamatan'])->asArray()->one();
            $items[] = ["id" => $nama->id, "fullname" => $nama->fullname, "lat" => $nama->lat, "long" => $nama->long, "id_kecamatan" => $tmp['id_kecamatan']];
        }
        
        return $this->render('map', [
            'items' => $items
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
//        $model = User::find()->select(['fullname', 'bio', 'lat', 'long'])->one();
        $model = User::findOne($id);
        $modelProductSearch = new ProductSearch();
        $modelProductSearch->user_id = $id;
        $dataProvider = $modelProductSearch->search(Yii::$app->request->queryParams);
        $dataProvider->setPagination(['defaultPageSize' => 4]);
        //$ownedProducts = Product::find()->where(['user_id' => $model->id])->all();
        
        return $this->render('view', [
            'model' => $model, 'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        
        if ($model->load(Yii::$app->request->post())) {
            
            if ($user = $model->signup()) {
                echo "<script>alert('Pembuatan user baru berhasil')</script>";
                return $this->redirect(['index']);
            } else {
                echo "<script>alert('Pembuatan user baru gagal')</script>";
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionChangepass()
    {
        $model = new ChangePasswordForm();
        $model->userId = Yii::$app->user->id;
        
        if ($model->load(Yii::$app->request->post())) {            
            if ($user = $model->changePassword()) {
                echo "<script>alert('Anda telah berhasil mengganti password.')</script>";
                return $this->goBack();
            }
        }

        return $this->render('changepassword', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        if (isset($id) && Yii::$app->user->identity->role == 'admin') {
            $model = $this->findModel($id);
        } else {
            $model = $this->findModel(Yii::$app->user->id);
        }
        $oldFile = $model->getImageFile();
        $oldAvatar = $model->avatar;
        $oldFileName = $model->filename;

        if ($model->load(Yii::$app->request->post())) {
            $image = $model->uploadImage();

            if ($image === false) {
                $model->avatar = $oldAvatar;
                $model->filename = $oldFileName;
            }
            
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) { // delete old and overwrite
                    if ($oldFile !== null) {unlink($oldFile);}
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                    //create thumbnail
                    $pathThumbnail = $model->getImageFileThumbnail();
                    Image::thumbnail($path, 160, 160)->save($pathThumbnail, ['quality' => 80]);
                }
                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                // error in saving model
            }
        }
        return $this->render('update', [
            'model'=>$model,
        ]);
            
            
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        
        //delete all product own by this user
        $products = Product::find()->where(['user_id' => $id])->all();
        foreach ($products as $p) {
            $p->delete();
        }
          
        // validate deletion and on failure process any exception
        // e.g. display an error message
        if ($model->delete()) {
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash('error', 'Error deleting image');
            }
        }
        return $this->redirect(['index']);
    }

    
    
    
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
