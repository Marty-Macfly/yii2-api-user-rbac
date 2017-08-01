# yii2-api-user-rbac

Yii2 User and Rbac provider from another Yii2 instance for sso or cenralized way to manage user and role.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist "macfly/yii2-api-user-rbac" "*"
```

or add

```
"macfly/yii2-api-user-rbac": "*"
```

to the require section of your `composer.json` file.

Configure
------------

> **NOTE:** Make sure that you don't have `user` component configuration in your config files.

Configure **config/web.php** as follows

```php
'modules' => [
    ................
    'userapi'  => [
        'class'       => 'macfly\user\server\Module',
        // For example if you want to use an oauth2 authentication to get User information,
        // you can of course any way you like to authenticate user.
        'as authenticator'  => [
            'class'         => \filsh\yii2\oauth2server\filters\auth\CompositeAuth::className(),
            'authMethods'   => [
                ['class'    => yii\filters\auth\HttpBearerAuth::className()],
                ['class'    => yii\filters\auth\QueryParamAuth::className(), 'tokenParam' => 'accessToken'],
            ],
        ],
    ],
    ................
],
```

Usage
------------

Provide the 2 following rest controller :

* PUT /userapi/identity send request to Yii::$app->user->identity 
* PUT|POST /userapi/rbac send request to Yii::$app->authManager

You can use PUT and POST to split read and write action for [Authorization](http://www.yiiframework.com/doc-2.0/guide-security-authorization.html)

 

