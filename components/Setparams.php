<?php

namespace app\components;

use yii\base\BootstrapInterface;
use Yii;

class Setparams implements BootstrapInterface
{
    public function bootstrap($app)
    {
        // Here you can refer to Application object through $app variable
        $app->params['avatarUploadPath'] = $app->basePath . '/web/uploads/avatars/';
        $app->params['avatarUploadUrl'] = $app->urlManager->baseUrl . '/uploads/avatars/';
        $app->params['productUploadPath'] = $app->basePath . '/web/uploads/products/';
        $app->params['productUploadUrl'] = $app->urlManager->baseUrl . '/uploads/products/';
        $app->params['slidepicUploadPath'] = $app->basePath . '/web/uploads/slidepics/';
        $app->params['slidepicUploadUrl'] = $app->urlManager->baseUrl . '/uploads/slidepics/';

//        $app->params['uploadPath'] = $app->basePath . '/uploads/';

        //      $app->params['uploadUrl'] = $app->urlManager->baseUrl . '/uploads/';
    }
}