<?php

use yii\helpers\Html;

//use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$productName = $model->product_name;
$this->title = $productName;
//$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/jquery.bxslider.css">


<div class="product-view">

    <h1>
        <?php
        echo Html::encode($this->title) . "     ";

        if (\Yii::$app->user->can('updateOwnProduct', ['product' => $model])) {
            echo Html::a('<i class="glyphicon glyphicon-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) . "     ";
            echo Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) . "     ";
            echo Html::a('<i class="glyphicon glyphicon-th-list"></i> Daftar Produk', ['index'], ['class' => 'btn btn-success']);
        }
        ?>
    </h1>

    <br>
    <div class="row">
        <div class="col-sm-12 col-md-6">

            <ul class="viewSlider">
                <?php $i = 0;
                foreach ($productPictures as $pp) { ?>
                    <li>
                        <?= Html::img($pp->getImageUrl(), ['alt' => $productName, 'class' => 'zoom' . $i, 'id' => 'viewPicture']); ?>
                    </li>
                    <?php $i++;
                } ?>
            </ul>
            <div id="viewPager">
                <?php $i = 0;
                foreach ($productPictures as $pp) { ?>
                    <a data-slide-index="<?= $i; ?>" href="">
                        <?php echo Html::img($pp->getImageUrlThumbnail(), ['alt' => $productName, 'class' => 'col-sm-2 img-rounded', 'width' => '100']); ?>
                    </a>
                    <?php $i++;
                } ?>
                <br/>
                <br/>
            </div>
        </div>


        <div class="col-sm-12 col-md-6 product-info">
            <p class="btn btn-primary rupiah"><?= $model->price ?></p>
            <p class="btn btn-default">Stock: <?= $model->stock ?></p>
            <br><br>
            <p><strong>Deskripsi Barang: <br> </strong><?= $model->description ?></p>
            <p><strong>Kategori: </strong><?= $category_name ?></p>
            <p><strong>Kode Produk: </strong><?= $model->product_code ?></p>
            <p><strong>Penjual: </strong><a
                    href="<?= Yii::$app->request->baseUrl . '/user/view?id=' . $seller->id ?>"><?= $seller->fullname ?></a>
            </p>
            <!--            <a id="sendMessageLink" value="<?= '<br/>'//Yii::$app->request->baseUrl . '/message/create?toId=' . $seller->id     ?>" class="btn btn-success">Kirim Pesan</a> -->
        </div>
    </div>

    <br>
    <div class="row-fluid">
        <h3>Produk Terkait</h3>
        <?php
        foreach ($relatedProducts as $rp) { ?>
            <div class="col-md-3 col-sm-4 col-xs-6" style="padding: 5px">
                <div class="product-grid">
                    <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $rp['id'] ?>">
                        <?php
                        if (isset($rp['productPictures'][0]['picture'])) {
                            echo Html::img(Yii::$app->request->baseUrl . '/uploads/products/' . $rp['id'] . '/thumbnail/' . $rp['productPictures'][0]['picture'], ['alt' => $rp['product_name'], 'class' => 'img-rounded product-grid-image']);
                        } else {
                            echo Html::img(Yii::$app->request->baseUrl . '/uploads/products/' . "empty_picture_thumbnail.jpg", ['alt' => 'Empty Product', 'class' => 'img-rounded product-grid-image']);
                        }
                        ?>
                    </a>
                    <h4 style="text-align: center"><a
                            href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $rp['id'] ?>"><?= $rp['product_name'] ?></a>
                    </h4>
                    <p style="text-align: center"><?= $rp['short_description'] ?></p>
                    <div style="text-align: center">
                        <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $rp['id'] ?>"
                           class="btn btn-primary rupiah"><?= $rp['price'] ?></a>
                        <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $rp['id'] ?>"
                           class="btn btn-default">Stock: <?= $rp['stock'] ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
</div>

