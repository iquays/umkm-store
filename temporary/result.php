<?php

use forecho\jqtree\JQTree;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
$this->title = 'Jombang UMKM';
?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/jqtree.style.css"/>

<div class="site-index">


    <div class="row">

        <?php Pjax::begin() ?>
        <div class="col-md-3">
            <div class="row">
                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6 cat-browser">
                    <h4 class="cat-title">LIHAT PER KATEGORI</h4>
                    <?php
                    echo JQTree::widget([
                        'id' => 'treeview',
                        'data' => $items,
                        'dragAndDrop' => false,
                        'saveState' => 'jqTreeState',
                        'autoOpen' => false,
                        'onCreateLi' => new \yii\web\JsExpression("
                        function(node, li) {
                            li.find('.jqtree-title').wrap('<a href=' + node.href + '></a>');                                
                        }
                    ")
                    ]);
                    ?>
                </div>
            </div>
        </div>


        <div id="result" class="col-md-9">
            <h3 class="titleResult"><?= $title ?></h3>
            <?php
            $searchedProducts = $dataProvider->models; ?>
            <?php $i = 1 ?>
            <?php foreach ($searchedProducts as $sp): ?>
                <div class="col-md-4 col-sm-6 col-xs-12" style="padding: 5px">
                    <div class="product-grid">
                        <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $sp['id'] ?>">
                            <?php
                            if (isset($sp['productPictures'][0]['picture'])) {
                                echo Html::img(Yii::$app->request->baseUrl . '/uploads/products/' . $sp['id'] . '/thumbnail/' . $sp['productPictures'][0]['picture'], ['class' => 'img-rounded product-grid-image']);
                            } else {
                                echo Html::img(Yii::$app->request->baseUrl . '/uploads/products/' . "empty_picture_thumbnail.jpg", ['class' => 'img-rounded product-grid-image']);
                            }
                            ?>
                        </a>
                        <h4 style="text-align: center"><a
                                    href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $sp['id'] ?>"><?= $sp['product_name'] ?></a>
                        </h4>
                        <p style="text-align: center"><?= $sp['short_description'] ?></p>
                        <div style="text-align: center">
                            <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $sp['id'] ?>"
                               class="rupiah btn btn-primary"><?= $sp['price'] ?></a>
                            <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $sp['id'] ?>"
                               class="btn btn-default">Stock: <?= $sp['stock'] ?></a>
                        </div>
                    </div>
                </div>
                <?php if (($i % 3) == 0): ?>
                    <div class="clearfix visible-md visible-lg"></div>
                <?php elseif (($i % 2) == 0): ?>
                    <div class="clearfix visible-sm"></div>
                <?php endif; ?>
                <?php $i++ ?>
            <?php endforeach; ?>
            <div class="clearfix visible-sm visible-md visible-lg"></div>
            <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
        </div>
        <?php Pjax::end() ?>
    </div>


    <div class="body-content">

        `
    </div>
</div>

