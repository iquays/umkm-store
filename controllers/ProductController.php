<?php

namespace app\controllers;

use app\models\Product;
use app\models\ProductCategory;
use app\models\ProductPicture;
use app\models\ProductSearch;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'view', 'index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin', 'member'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['member', 'admin'],
                    ],
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['member', 'admin'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?', '@'],
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->role == 'admin') {
            $searchModel = new ProductSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            $searchModel = new ProductSearch();
            $searchModel->user_id = Yii::$app->user->id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $relatedProducts = Product::find()->where(['category_id' => $model->category_id])->andWhere(['not', ['id' => $id]])->limit(4)->all();
        $productPictures = ProductPicture::find()->where(['product_id' => $id])->all();
        $category_name = ProductCategory::findOne($model->category_id)->category_name;
        $seller = User::findOne($model->user_id);
        return $this->render('view', [
            'model' => $model, 'productPictures' => $productPictures, 'relatedProducts' => $relatedProducts, 'seller' => $seller, 'category_name' => $category_name
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $cat1 = ProductCategory::find()->where(['product_category.parent_category_id' => null])->orderBy('category_name')->all();
        foreach ($cat1 as $c1) {
            $category[$c1->id] = $c1->category_name;
            $cat2 = ProductCategory::find()->where(['product_category.parent_category_id' => $c1->id])->orderBy('category_name')->all();
            foreach ($cat2 as $c2) {
                $category[$c2->id] = "— " . $c2->category_name;
            }
        }

        $model = new Product();
        $model->user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = date('Y-m-d');
            if ($model->save()) {
//              Create product code automatically based on category and id of product                    
                $model->product_code = ProductCategory::findOne($model->category_id)->category_code . (string)$model->id;
                $model->update();
//                return $this->redirect(['view', 'id' => $model->id]);
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model, 'category' => $category, 'product_id' => Yii::$app->mycomponent->generateProductId(),
            ]);
        }
    }

    /**
     * Upload function to handle AJAX file upload request
     */

    public function actionUpload()
    {
        // Check if no file for upload
        if (empty($_FILES['file'])) {
            echo json_encode(['errors' => 'No file(s) found for upload']);
            return;
        }

        // Get the file(s)
        $files = $_FILES['file'];

        $success = NULL;
        $paths = [];

        $filenames = $files['name'];

        if (!file_exists(Yii::$app->params['productUploadPath'] . DIRECTORY_SEPARATOR . $_POST['product_id'])) {
            mkdir(Yii::$app->params['productUploadPath'] . DIRECTORY_SEPARATOR . $_POST['product_id']);
            mkdir(Yii::$app->params['productUploadPath'] . DIRECTORY_SEPARATOR . $_POST['product_id'] . DIRECTORY_SEPARATOR . 'thumbnail');
        }

        $preview = [];
        $previewConfig = [];
        for ($i = 0; $i < count($filenames); $i++) {
            $filename = $_POST['product_id'] . '_' . $filenames[$i];
            $target = Yii::$app->params['productUploadPath'] . $_POST['product_id'] . DIRECTORY_SEPARATOR . $filename;
//            $targetThumbnail = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $_POST['product_id'] . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR . $filename;
            $targetThumbnail = Yii::$app->params['productUploadPath'] . $_POST['product_id'] . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR . $filename;
            if (move_uploaded_file($files['tmp_name'][$i], $target)) {
                $success = TRUE;
                $paths[] = $target;
                $modelProductPicture = new ProductPicture();
                $modelProductPicture->product_id = $_POST['product_id'];
                $modelProductPicture->picture = $filename;
                $modelProductPicture->save();
                Image::thumbnail($target, 120, 120)->save($targetThumbnail, ['quality' => 70]);
                $preview[$i] = Html::img($modelProductPicture->getImageUrl(), ['style' => 'height:160px', 'class' => 'file-preview-image']);
                $previewConfig[$i] = ['url' => Yii::$app->homeUrl . 'productpicture/delete?id=' . $modelProductPicture->id, 'caption' => $modelProductPicture->picture];
            } else {
                $success = FALSE;
                break;
            }
        }

        if ($success === TRUE) {
            $output = ['succeeded' => 'file uploaded', 'initialPreview' => $preview, 'initialPreviewConfig' => $previewConfig, 'append' => true];
//            $output = ['error' => $target . '<==>' . $targetThumbnail, 'initialPreview' => $preview, 'initialPreviewConfig' => $previewConfig, 'append' => true];
        } elseif ($success === FALSE) {
            $output = ['error' => 'Error while upload'];
            foreach ($paths as $path) {
                unlink($path);
            }
        } else {
            $output = ['error' => 'No file(s) were processed'];
        }

        echo json_encode($output);
    }


    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $cat1 = ProductCategory::find()->where(['product_category.parent_category_id' => null])->orderBy('category_name')->all();
        foreach ($cat1 as $c1) {
            $category[$c1->id] = $c1->category_name;
            $cat2 = ProductCategory::find()->where(['product_category.parent_category_id' => $c1->id])->orderBy('category_name')->all();
            foreach ($cat2 as $c2) {
                $category[$c2->id] = "— " . $c2->category_name;
            }
        }

        $model = $this->findModel($id);
        if (Yii::$app->user->can('updateOwnProduct', ['product' => $model]) || Yii::$app->user->identity->role == 'admin') {
            if ($model->load(Yii::$app->request->post())) {
                $model->updated_at = date('Y-m-d');
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('update', [
                    'model' => $model, 'category' => $category
                ]);
            }
        } else {
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Product model.P
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $dirname = Yii::$app->params['productUploadPath'] . DIRECTORY_SEPARATOR . $model->id;
        Yii::$app->mycomponent->rrmdir($dirname);
        if (Yii::$app->user->can('updateOwnProduct', ['product' => $model]) || Yii::$app->user->identity->role == 'admin') {
//            $productPicture = ProductPicture::find()->where(['product_id' => $id])->all();
            foreach ($model->productPictures as $pP) {
                $pP->delete();
            }

            $model->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMovefile()
    {
        $productPictures = ProductPicture::find()->all();
        foreach ($productPictures as $pP) {
            if (!file_exists(Yii::$app->params['productUploadPath'] . DIRECTORY_SEPARATOR . $pP->product_id)) {
                mkdir(Yii::$app->params['productUploadPath'] . DIRECTORY_SEPARATOR . $pP->product_id);
                mkdir(Yii::$app->params['productUploadPath'] . DIRECTORY_SEPARATOR . $pP->product_id . DIRECTORY_SEPARATOR . 'thumbnail');
            }
            $sourceFile = Yii::$app->params['productUploadPath'] . $pP->picture;
            $sourceThumbnail = Yii::$app->params['productUploadPath'] . 'thumbnails' . DIRECTORY_SEPARATOR . $pP->picture;
            $destinationFile = Yii::$app->params['productUploadPath'] . $pP->product_id . DIRECTORY_SEPARATOR . $pP->picture;
            $destinationThumbnail = Yii::$app->params['productUploadPath'] . $pP->product_id . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR . $pP->picture;
            if (file_exists($sourceFile)) {
                rename($sourceFile, $destinationFile);
            }
            if (file_exists($sourceThumbnail)) {
                rename($sourceThumbnail, $destinationThumbnail);
            }
        }
        $this->goHome();
    }
}
