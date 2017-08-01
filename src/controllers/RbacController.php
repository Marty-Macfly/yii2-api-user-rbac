<?php

namespace macfly\user\server\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class RbacController extends BaseController
{
    public function actionCreate($method)
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
                $obj	    = \Yii::createObject($arr);
                $args[$k]   = $obj;
            }
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

    public function actionUpdate($method)
    {
        if(in_array($method, ['add', 'addChild', 'assign','canAddChild',
            'createPermission', 'createRole', 'remove', 'removeAll',
            'removeAllAssignments','removeAllPermissions', 'removeAllRoles',
            'removeAllRules', 'removeChild', 'removeChildren', 'revoke',
            'revokeAll', 'update']))
        {
            throw new UnauthorizedHttpException(sprintf("Method '%s' not allowed through PUT (read access), you should use POST for write access", $method));
        }

        return $this->actionCreate($method);
    }
}
