<?php

namespace macfly\user\server;

use Yii;
use yii\console\Application as ConsoleApplication;

class Bootstrap implements \yii\base\BootstrapInterface
{
    /** @inheritdoc */
    public function bootstrap($app)
    {
        if ($app->hasModule('userapi') && ($module = $app->getModule('userapi')) instanceof Module)
        {
            if ($app instanceof ConsoleApplication)
            {
                $module->controllerNamespace = 'macfly\user\server\commands';
            } else
            {
                $configUrlRule = [
                    'class'		=> 'yii\web\GroupUrlRule',
                    'prefix'    => $module->urlPrefix,
                    'rules'		=> $module->urlRules,
                ];

                if ($module->urlPrefix != 'userapi')
                {
                    $configUrlRule['routePrefix'] = 'userapi';
                }

                $rule	= Yii::createObject($configUrlRule);

                $app->urlManager->addRules([$rule], false);
            }
        }
    }
}
