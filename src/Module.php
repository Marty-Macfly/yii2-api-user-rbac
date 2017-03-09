<?php

namespace macfly\user\server;

use Yii;

class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{
	/**
	 * @var string The prefix for user module URL.
	 *
	 * @See [[GroupUrlRule::prefix]]
	 */
	public $urlPrefix = 'userapi';

	/** @var array The rules to be used in URL management. */
	public $urlRules = [
		'rbac/<method:\w+>'			=> 'rbac/update',
		'identity/<method:\w+>'	=> 'identity/update',
	];

  public function init()
  {
    parent::init();

    if(Yii::$app->has('user'))
    {
      Yii::$app->user->enableSession = false;
    }
  }

  /** @inheritdoc */
  public function bootstrap($app)
  {
		if ($app instanceof ConsoleApplication) {
			$this->controllerNamespace = 'macfly\user\server\commands';
		} else
		{
			$configUrlRule = [
				'class'		=> 'yii\web\GroupUrlRule',
				'prefix'	=> $this->urlPrefix,
				'rules'		=> $this->urlRules,
			];

			if ($this->urlPrefix != 'userapi')
			{
				$configUrlRule['routePrefix'] = 'userapi';
			}

			$rule	= Yii::createObject($configUrlRule);

			$app->urlManager->addRules([$rule], false);
    }
  }
}
