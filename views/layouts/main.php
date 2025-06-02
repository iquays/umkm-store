<?php
use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

//use iutbay\yii2fontawesome\FontAwesome as FA;

//use yii\helpers\Url;
//use yii\bootstrap\Nav;
//use yii\widgets\Breadcrumbs;
//use app\assets\FontAwesomeAsset;

//use app\models\ProductCategory;
//use app\models\SearchForm;
//use kartik\select2\Select2;
//use kartik\form\ActiveForm;
//use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="Walery produk dari UKM (Usaha Kecil dan Menengah) Kabupaaten Jombang Jawa Timur. Batik, meubel, bordir, kerajinan logam, dan prodkuk kerajinan lainnya.">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        @media print {
        }
    </style>
</head>

<body>

<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'UKM Jombang',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    ?>

    <form method="get" class="navbar-form pull-left" role="search"
          action=<?= Yii::$app->request->baseUrl . '/site/result/'; ?>>
        <div class="input-group">
            <input name="product_name" type="text" class="form-control" placeholder="Cari Produk">
            <div class="input-group-btn">
                <button type="submit" class="btn btn-success"><span class="glyphicon-search"></span></button>
            </div>
        </div>
    </form>

    <?php

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            ['label' => '<i class="glyphicon-home"></i>Home', 'url' => ['/site/index']],
//            ['label' => '<i class="glyphicon-doc-text"></i>Berita', 'url' => ['/berita/show']],
            ['label' => '<i class="glyphicon-plus"></i>Buat Iklan', 'url' => ['/product/create'], 'visible' => !((!Yii::$app->user->isGuest) && (Yii::$app->user->identity->role == 'admin'))],
            ['label' => '<i class="glyphicon-th-large"></i> Admin Area', 'visible' => ((!Yii::$app->user->isGuest) && (Yii::$app->user->identity->role == 'admin')),
                'items' => [
                    ['label' => '<i class="glyphicon-location"></i> Lokasi Users', 'url' => ['/user/map']],
                    ['label' => '<i class="glyphicon-book"></i> Daftar User UMKM', 'url' => ['/user/index']],
                    ['label' => '<i class="glyphicon-plus"></i> Buat User Baru', 'url' => ['/user/create']],
                    '<li class="divider"></li>',
                    ['label' => '<i class="glyphicon-th-list"></i> Daftar Semua Produk', 'url' => ['/product/index']],
                    '<li class="divider"></li>',
                    ['label' => '<i class="glyphicon-th-list"></i> Daftar Slideshow', 'url' => ['/slidepic/index']],
                    '<li class="divider"></li>',
                    ['label' => '<i class="glyphicon-th-list"></i> Daftar Berita', 'url' => ['/berita/index']],
                    ['label' => '<i class="glyphicon-plus"></i> Buat Berita', 'url' => ['/berita/create']],
                    '<li class="divider"></li>',
                    ['label' => '<i class="glyphicon-th-list"></i> Daftar Kategori Berita', 'url' => ['/beritacategory/index']],
                    ['label' => '<i class="glyphicon-plus"></i> Buat Kategori Berita', 'url' => ['/beritacategory/create']],
                ],
            ],
            Yii::$app->user->isGuest ?
                ['label' => '<i class="glyphicon-login"></i>Login', 'url' => ['/site/login']] :
//                        ['label' => '<i class="glyphicon- glyphicon--log-in"></i> Login', 'url' => ['/site/login1']] :
//                    '<li><a id="modalLink" href="#" value='. '/jumkm/web/site/loginmodal' . '><i class="glyphicon- glyphicon--log-in"></i> Login</a></li>' :

                ['label' => '<i class="glyphicon-user"></i>' . Yii::$app->user->identity->username,
                    'items' => [
                        ['label' => '<i class="glyphicon-pencil"></i> Ubah Profil', 'url' => ['/user/update']],
                        ['label' => '<i class="glyphicon-th-list"></i> Daftar Iklan Produk', 'url' => ['/product/index'], 'visible' => Yii::$app->user->identity->role == 'member'],
                        '<li class="divider"></li>',
                        ['label' => '<i class="glyphicon-edit"></i> Ganti Password', 'url' => ['/user/changepass']],
                        ['label' => '<i class="glyphicon-logout"></i> Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                    ]
                ],
        ],
    ]);

    NavBar::end();

    ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row-fluid">
            <div class="col-md-3 clearfix">
                <h4 class="kepala">Tentang Kami</h4>
                <div class="widget-inner">
                    <p class="isi">Bagian Adm. Perekonomian Setda. Kab. Jombang - Jawa Timur - Indonesia memfasilitasi
                        pelaku UMKM Jombang untuk mengembangkan pemasaran produk. Silakan mendaftar di Bagian Adm.
                        Perekonomian untuk mendapatkan username dan password.</p>
                </div>
            </div>
            <div class="col-md-3 clearfix">
                <h4 class="kepala">Informasi</h4>
                <div class="widget-inner">
                    <p class="isi">Telp: 0321 - 862603</p>
                    <p class="isi">Fax: 0321 - 862603</p>
                    <p class="isi">Email: </p><a href="&#109;&#097;&#105;&#108;&#116;&#111;:&#097;&#100;&#101;&#116;&#097;&#108;&#097;&#115;&#101;&#064;&#121;&#097;&#104;&#111;&#111;&#046;&#099;&#111;&#046;&#105;&#100;">
                        &#097;&#100;&#101;&#116;&#097;&#108;&#097;&#115;&#101;&#064;&#121;&#097;&#104;&#111;&#111;&#046;&#099;&#111;&#046;&#105;&#100;</a>
                </div>
            </div>

            <div class="col-md-3 clearfix">
                <h4 class="kepala">Media Sosial</h4>
                <div class="widget-inner">
                    <p class="isi"><i class="glyphicon-facebook-square"></i> Facebook</p>
                    <p class="isi"><i class="glyphicon-twitter-square"></i> Twitter</p>
                    <p class="isi"><i class="glyphicon-linkedin-square"></i> LinkedIn</p>
                </div>
            </div>

            <div class="col-md-3 clearfix">
                <h4 class="kepala">Alamat</h4>
                <div class="widget-inner">
                    <p class="isi">Jl. KH Wakhid Hasyim 137</br>
                        Jombang - Jawa Timur</br>
                        Indonesia</p>
                    <p class="isi"><i class="glyphicon-location"></i> Lihat di peta</p>
                </div>
            </div>
        </div>
    </div>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
