<?php

use forecho\jqtree\JQTree;
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

//use yii\helpers\BaseJson;

/* @var $this yii\web\View */
$this->title = 'Jombang UMKM';

?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/jquery.bxslider.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/jqtree.style.css">


<div class="site-index">
    <div class="row-fluid">
        <div class="col-md-3">
            <div class="row">
                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6 thumbnail"
                     style="min-width:220px; max-width:220px; padding:10px;">
                    <div class="row-fluid" style="min-width: 200px; max-width: 200px;">
                        <img src="<?= Yii::$app->request->baseUrl ?>/images/logo-transparent.png"
                             class="img-thumbnail" alt="Logo Kabupaten Jombang">
                    </div>
                </div>

                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6 cat-browser">
                    <h4 class="cat-title" style="min-width: 200px;">LIHAT PER KATEGORI</h4>
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
        <div class="col-md-9">
            <div class="thumbnail">
                <?php echo $tt = Carousel::widget([
                    'id' => 'carousel',
                    'items' => $slideshows,
                    'controls' => ['<i class="glyphicon glyphicon-chevron-left"></i>', '<i class="glyphicon glyphicon-chevron-right"></i>'],
                    'options' => ['class' => 'carousel slide'],
                ]);
                ?>
            </div>

            <?php Pjax::begin(); ?>
            <div class="row">
                <h2>Produk Terbaru:</h2>
                <?php $featuredProducts = $dataProvider->models; ?>
                <?php $i = 1 ?>
                <?php foreach ($featuredProducts as $fp): ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding: 5px">
                        <div class="product-grid">
                            <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $fp['id'] ?>">
                                <?php
                                if (isset($fp['productPictures'][0]['picture'])) {
                                    echo Html::img(Yii::$app->request->baseUrl . '/uploads/products/' . $fp['id'] . '/thumbnail/' . $fp['productPictures'][0]['picture'], ['class' => 'img-rounded product-grid-image']);
                                } else {
                                    echo Html::img(Yii::$app->request->baseUrl . '/uploads/products/' . "empty_picture_thumbnail.jpg", ['class' => 'img-rounded product-grid-image']);
                                }
                                ?>
                            </a>
                            <h4 style="text-align: center"><a
                                        href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $fp['id'] ?>"><?= $fp['product_name'] ?></a>
                            </h4>
                            <p style="text-align: center"><?= $fp['short_description'] ?></p>
                            <div style="text-align: center">
                                <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $fp['id'] ?>"
                                   class="btn btn-primary rupiah"><?= $fp['price'] ?></a>
                                <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $fp['id'] ?>"
                                   class="btn btn-default">Stock: <?= $fp['stock'] ?></a>
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
            </div>
            <div>
                <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
            </div>
            <?php Pjax::end(); ?>


        </div>
    </div>

</div>


<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/jqtree.css"/>

<script>
    localStorage.clear('jqTreeState');
    //    var data = <?php//echo BaseJson::encode($items);?>;
</script>


