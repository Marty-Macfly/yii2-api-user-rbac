<?php

namespace macfly\user\server;

use Yii;

class Module extends \yii\base\Module
{
    /**
     * @var string The prefix for user module URL.
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'userapi';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
			'<controller:\w+>/<action:\w+>/<method:\w+>'  => '<controller>/<action>',
    ];
}
