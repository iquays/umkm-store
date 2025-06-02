<?php

namespace app\components;

use Yii;
use app\models\ProductIdSeq;
use yii\base\InvalidConfigException;
use yii\base\Object;

class MyComponent extends Object
{

    public function generateProductId()
    {
        $seq = new ProductIdSeq();
        $seq->save();
        return $seq->id;
    }

    public function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object))
                        Yii::$app->mycomponent->rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            rmdir($dir);
        }
    }

}