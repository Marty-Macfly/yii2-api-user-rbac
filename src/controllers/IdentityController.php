<?php

namespace macfly\user\server\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class IdentityController extends yii\rest\Controller
{
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

  public function actionUpdate($method)
  {
    $identity  = Yii::$app->user->identity;

    if(is_null($identity))
    {
      throw new UnauthorizedHttpException(sprintf("No user->identity"));
    }

    if(!$identity->hasMethod($method))
    {
      throw new NotFoundHttpException(sprintf("Identity doesn't provide method: '%s'", $method));
    }

    $args = Yii::$app->request->post();
    $obj  = call_user_func_array(array($identity, $method), $args);

    if(is_object($obj)) {
      $array					= ArrayHelper::toArray($obj);
      $array['class'] = $obj->className();
      return $array;
    }

    return $obj;
  }
}
