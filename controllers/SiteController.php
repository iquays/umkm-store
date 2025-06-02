<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\Product;
use app\models\ProductCategory;
use app\models\ProductSearch;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

//use app\models\ProductPicture;
//use yii\helpers\Html;
//use app\models\Slidepic;

//use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'about', 'index', 'result'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['result'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                    [
                        'actions' => ['about', 'index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionResult()
    {
        $category1 = ProductCategory::find()->where(['product_category.parent_category_id' => null])->orderBy('category_name')->all();
        foreach ($category1 as $c1) {
            $items[] = ['id' => $c1->id,
                'label' => $c1->category_name,
                'href' => Yii::$app->request->baseUrl . '/site/result?category_id=' . $c1->id
            ];
        }

        $category2 = ProductCategory::find()->where(['not', ['product_category.parent_category_id' => null]])->orderBy('category_name')->all();
        foreach ($category2 as $c2) {
            foreach ($items as $i => $item) {
                if ($item['id'] === $c2->parent_category_id) {
                    $items[$i]['children'][] = [
                        'id' => $c2->id,
                        'label' => $c2->category_name,
                        'href' => Yii::$app->request->baseUrl . '/site/result?category_id=' . $c2->id
                    ];
                }
            }
        }

        $productName = \filter_input(\INPUT_GET, 'product_name');
        $category_id = \filter_input(\INPUT_GET, 'category_id');
        $category_ids[] = $category_id;
        $childCat = ProductCategory::find()->where(['product_category.parent_category_id' => $category_id])->all();
        foreach ($childCat as $cC) {
            $category_ids[] = $cC->id;
        }

        if (isset($productName)) {
            $model = new ProductSearch();
            $model->product_name = $productName;
            $dataProvider = $model->search(Yii::$app->request->queryParams);
            $dataProvider->setPagination(['defaultPageSize' => 6]);
            $dataProvider->setSort([
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'product_name' => SORT_ASC,
                ]
            ]);

//            $model = Product::find()->where(['product_name' => $productName])->orderBy('created_at desc')->all();
//            $dataProvider = new ArrayDataProvider(['allModels' => $model, 'pagination' => ['defaultPageSize' => 6]]);

            $title = "Hasil pencarian produk dengan kata '" . $productName . "'";
            return $this->render('result',
                ['dataProvider' => $dataProvider, 'items' => $items, 'title' => $title]
            );
        } elseif ($category_id) {
            $modelCategory = ProductCategory::findOne($category_id);
            $category_name = $modelCategory->category_name;

            $model = Product::find()->where(['category_id' => $category_ids])->orderBy('created_at desc')->all();
            $dataProvider = new ArrayDataProvider(['allModels' => $model, 'pagination' => ['defaultPageSize' => 6]]);

            $dataProvider->count > 0 ? $title = "Daftar semua produk pada kategori '" . $category_name . "'" :
                $title = "Maaf, belum ada produk untuk kategori '" . $category_name . "'";
            return $this->render('result',
                ['dataProvider' => $dataProvider, 'items' => $items, 'title' => $title]
            );
        } else {
            return $this->goHome();
        }
    }


    public function actionIndex()
    {
        $category1 = ProductCategory::find()->where(['product_category.parent_category_id' => null])->orderBy('category_name')->all();
        foreach ($category1 as $c1) {
            $items[] = ['id' => $c1->id,
                'label' => $c1->category_name,
                'href' => Yii::$app->request->baseUrl . '/site/result?category_id=' . $c1->id
            ];
        }

        $category2 = ProductCategory::find()->where(['not', ['product_category.parent_category_id' => null]])->orderBy('category_name')->all();
        foreach ($category2 as $c2) {
            foreach ($items as $i => $item) {
                if ($item['id'] === $c2->parent_category_id) {
                    $items[$i]['children'][] = [
                        'id' => $c2->id,
                        'label' => $c2->category_name,
                        'href' => Yii::$app->request->baseUrl . '/site/result?category_id=' . $c2->id
                    ];
                }
            }
        }


        // Select random image for slide show
        $query = new Query;
//        $query->select('rand() as rand, picture, title, short_description')
//            ->from('slidepic')->orderBy('rand')->limit(7);
        $query->select('picture, title, short_description')->from('slidepic')->all();
        $slidepics = $query->all();
        $slideshows = [];
        foreach ($slidepics as $sp) {
            $slideshows[] = [
                'content' => Html::img(Yii::$app->request->baseUrl . '/uploads/slidepics/cropped/' . $sp['picture'], ['class' => 'center-block', 'alt' => $sp['title']]),
                'caption' => '<h4>' . $sp['title'] . '</h4>' . '<p>' . $sp['short_description'] . '</p>',
            ];
        }


        // Select latest product
        $model = Product::find()->orderBy('created_at desc')->limit(12)->all();
        $dataProvider = new ArrayDataProvider(['allModels' => $model, 'pagination' => ['defaultPageSize' => 6]]);


        return $this->render('index',
            ['items' => $items, 'slideshows' => $slideshows, 'dataProvider' => $dataProvider]
        );
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogin1()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login1', [
                'model' => $model,
            ]);
        }
    }

    public function actionLoginmodal()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->loginModal()) {
            return $this->goBack();
        } else {
            return $this->renderAjax('loginmodal', [
                'model' => $model,
            ]);
        }
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {
                echo "<script>alert('Proses pendaftaran berhasil')</script>";
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            } else {
                echo "<script>alert('Proses pendaftaran gagal')</script>";
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}
