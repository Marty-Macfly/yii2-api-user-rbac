<?php

namespace macfly\user\server\controllers;

use Yii;
use yii\filters\VerbFilter;

class BaseController extends \yii\rest\Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors  = parent::behaviors();
        $behaviors['verbs']   = [
            'class' => VerbFilter::className(),
            'actions' => [
                'update' => ['put'],
            ],
        ];
        return $behaviors;
    }

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        if(Yii::$app->has('user'))
        {
            Yii::$app->user->enableSession = false;
        }
    }
}
