<?php

namespace RotHub\Yii\Web;

class Config
{
    public static function main(): array
    {
        return [
            'id' => 'app',
            'timeZone' => 'PRC',
            'language' => 'zh-CN',
        ];
    }

    public static function user(): array
    {
        return [
            'class' => 'RotHub\Yii\Web\User',
            'identityClass' => 'RotHub\Yii\Web\UserIdentity',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ];
    }

    public static function cache(): array
    {
        return ['class' => 'yii\caching\FileCache'];
    }

    public static function request(): array
    {
        return [
            'cookieValidationKey' => '05368BD30A33FA6CA6AB3F691D3D41D0',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ];
    }

    public static function response(): array
    {
        return [
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'on beforeSend' => function ($event) {
                $model = new \RotHub\Yii\Web\Response;
                $model->event = $event;
                $model->callback = 'RotHub\Yii\Models\ChangeLog::add';
                $model->beforeSend();
            }
        ];
    }

    public static function error(): array
    {
        return ['class' => 'RotHub\Yii\Exceptions\ErrorHandler'];
    }

    public static function url(): array
    {
        return [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '<module:[\w-]+>' => '<module>',
                '<module:[\w-]+>/<controller:[\w-]+>' =>
                '<module>/<controller>',
                '<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>' =>
                '<module>/<controller>/<action>',
            ],
        ];
    }

    public static function gii(): array
    {
        return [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'], // ['127.0.0.1', '::1'].
            'generators' => [
                'model' => [
                    'class' => 'RotHub\Yii\Templates\Model\Generator',
                    'templates' => [
                        'RESTfulModel' => '@vendor/RotHub/Yii/src/Templates/Model/Restful',
                    ],
                ],
            ],
        ];
    }
}
