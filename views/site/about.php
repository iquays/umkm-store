<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <h3>
        <?php
        $db = Yii::$app->db;

        //        $transaction = $db->beginTransaction();
        $customer1 = \app\models\Akun::findOne(1);
        $customer2 = \app\models\Akun::findOne(2);
        $transaction = \app\models\Akun::getDb()->beginTransaction();
        try {
//            $saldo_1 = $db->createCommand('select saldo from akun where id = 1')->queryScalar();
//            $saldo_2 = $db->createCommand('select saldo from akun where id = 3')->queryScalar();
//            $db->createCommand()->update('akun', [
//                'saldo' => 1000], 'id = 1')->execute();
//            $db->createCommand()->update('akun', [
//                'saldo' => 1000], 'id = 3')->execute();
//            $db->createCommand('update akun set saldo = 1000 where id = 1; update akun set saldo = 1000 where id = 3')->execute();
            // ... executing other SQL statements here...

            $customer1->saldo = $customer1->saldo + 1000;
            $customer1->save();
            $customer2->saldo = $customer2->saldo - 1000;
            $customer2->save();

            $transaction->commit();

            // Following code is for checking only
            echo "<script>console.log('Succeed')</script>";

        } catch (\Exception $e) {
            $transaction->rollBack();

            // Following code is for checking only
            echo "<script>console.log('Failed')</script>";

//            throw $e;
        }

        ?>
    </h3>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>
