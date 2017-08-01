<?php

namespace macfly\user\server\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

class BaseController extends \yii\rest\Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors  = parent::behaviors();
        $behaviors['verbs']   = [
            'class' => VerbFilter::className(),
            'actions' => [
                'read'	=> ['put'],
                'write'	=> ['put'],
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

				// Default reply format is json for api
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    protected function call($provider, $method, $args)
    {
        if(is_null($provider))
        {
            throw new UnauthorizedHttpException(sprintf("Provider is not setup properly"));
        }

        if(!$provider->hasMethod($method))
        {
            throw new NotFoundHttpException(sprintf("Provider doesn't provide method: '%s'", $method));
        }

        $obj	= call_user_func_array(array($authManager, $method), $args);

        if(is_object($obj))
        {
            $array			= ArrayHelper::toArray($obj);
            $array['class']	=	$obj->className();
            return $array;
        }

        return $obj;
    }
}
