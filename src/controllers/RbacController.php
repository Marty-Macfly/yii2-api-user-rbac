<?php

namespace macfly\user\server\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class RbacController extends BaseController
{
	public function actionUpdate($method)
	{
		$authManager	= Yii::$app->authManager;

		if(!$authManager->hasMethod($method))
		{
			throw new NotFoundHttpException(sprintf("AuthManager doesn't not provide method: '%s'", $method));
		}

		$args	= Yii::$app->request->post();

		foreach($args as $k => $arr)
		{
	    if(is_array($arr) && array_key_exists('class', $arr))
    	{
				$obj			= \Yii::createObject($arr);
				$args[$k]	= $obj;
    	}
		}

		$obj	= call_user_func_array(array($authManager, $method), $args);

		if(is_object($obj))
		{
			$array					= ArrayHelper::toArray($obj);
			$array['class']	=	$obj->className();
			return $array;
		}

		return $obj;
	}
}
