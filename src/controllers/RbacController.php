<?php

namespace macfly\user\server\controllers;

use Yii;
use yii\web\UnauthorizedHttpException;

class RbacController extends BaseController
{
    public function actionWrite($method)
    {
        $args	= Yii::$app->request->post();

        foreach($args as $k => $arr)
        {
            if(is_array($arr) && array_key_exists('class', $arr))
            {
                $obj	    = \Yii::createObject($arr);
                $args[$k]   = $obj;
            }
        }

        return parent::call(Yii::$app->authManager, $method, $args);
    }

    public function actionRead($method)
    {
        if(in_array($method, ['add', 'addChild', 'assign','canAddChild',
            'createPermission', 'createRole', 'remove', 'removeAll',
            'removeAllAssignments','removeAllPermissions', 'removeAllRoles',
            'removeAllRules', 'removeChild', 'removeChildren', 'revoke',
            'revokeAll', 'update']))
        {
            throw new UnauthorizedHttpException(sprintf("Method '%s' not allowed through PUT (read access), you should use POST for write access", $method));
        }

        return $this->actionWrite($method);
    }
}
