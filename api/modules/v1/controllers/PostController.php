<?php

namespace api\modules\v1\controllers;

use api\models\Post;
use yii\rest\ActiveController;

class PostController extends ActiveController
{
    public $modelClass = Post::class;
}