<?php


return [
    'adminEmail' => 'iquays@gmail.com',
//    'avatarUploadPath' => Yii::$app->basePath . '/uploads/avatars/',
    //'avatarUploadUrl' => Yii::$app->homeUrl . '/uploads/avatars/',
//    'productUploadPath' => Yii::$app->basePath . '/uploads/products/',
  //  'productUploadUrl' => Yii::$app->urlManager->baseUrl . '/uploads/products/',
    'maskMoneyOptions' => [
        'prefix' => 'Rp. ',
        'suffix' => '',
        'affixesStay' => true,
        'thousands' => '.',
        'decimal' => ',',
        'precision' => 2,
        'allowZero' => true,
        'allowNegative' => false,
    ]
];
