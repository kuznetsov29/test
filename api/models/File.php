<?php

namespace api\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "file".
 *
 * Class File
 * @property int $id
 * @property string $path
 * @property int $status
 * @property string $extension
 * @property string $base_name
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $name
 * @property string $fullPath
 *
 * @author Pavel Kuznetsov <kuznetsov-web@bk.ru>
 * @package fruktozets\dropzone
 */
class File extends \common\models\File
{
    /**
     * @return string
     */
    public function getShortPath()
    {
        return $this->path . $this->base_name . '.' . $this->extension;
    }

    /**
     * @return bool|string
     */
    public function getUrl()
    {
        return Yii::getAlias('@web/uploads/' .  $this->getShortPath());
    }


    /**
     * @return array
     */
    public function fields()
    {
        return [
            'base_name',
            'url' => function (File $model) {
                return $model->getUrl();
            },
        ];
    }
}
