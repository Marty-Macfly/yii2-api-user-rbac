<?php

namespace macfly\user\server\controllers;

use Yii;

class IdentityController extends BaseController
{
    public function actionRead($method)
    {
        return parent::call(Yii::$app->user->identity, $method, Yii::$app->request->post());
    }
}
