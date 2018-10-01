<?php
/**
 * Created by PhpStorm.
 * User: inna
 * Date: 26.09.18
 * Time: 20:14
 */

namespace api\modules\v1;


use yii\web\Response;

class Module extends \yii\base\Module
{
    public function init()
    {
        header('Access-Control-Allow-Origin: *');
        \Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }

}