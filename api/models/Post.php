<?php

namespace api\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property int $image_id
 *
 * @property File $image
 */
class Post extends \common\models\Post
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(File::className(), ['id' => 'image_id']);
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'title',
            'description',
            'content',
            'short_content' => function (Post $model) {
                return mb_substr(strip_tags($model->content), 0, 200);
            },
        ];
    }

    /**
     * @return array
     */
    public function extraFields()
    {
        return [
            'image',
        ];
    }
}