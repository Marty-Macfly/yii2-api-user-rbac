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
       'as authenticator'  => [
         'class'       => \filsh\yii2\oauth2server\filters\auth\CompositeAuth::className(),
         'authMethods' => [
            ['class' => yii\filters\auth\HttpBearerAuth::className()],
            ['class' => yii\filters\auth\QueryParamAuth::className(), 'tokenParam' => 'accessToken'],
          ],
       ],
     ],
      ................
  ],
```
