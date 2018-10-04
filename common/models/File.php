<?php

namespace common\models;

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
class File extends \yii\db\ActiveRecord
{
    const STATUS_UPLOADED = 5;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;

    const SCENARIO_IMAGE = 'images';
    const SCENARIO_DOCUMENT = 'document';
    const FILE_NAME_ORIGINAL = 'original';

    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @var string
     */
    public $basePath = '@webroot';

    /**
     * @var string
     */
    public $uploadPath = '/uploads/';

    /**
     * ['file', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024]
     *
     * @var array
     */
    public $fileRule;


    public function getName()
    {
        return File::FILE_NAME_ORIGINAL . '.' . $this->extension;
    }

    public function getFullPath()
    {
        return Yii::getAlias($this->basePath . $this->path);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_IMAGE] = ['path', 'file', 'mime_type', 'base_name'];
        $scenarios[self::SCENARIO_DOCUMENT] = ['path', 'file', 'mime_type', 'base_name'];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            ['created_by', 'default', 'value' =>  1],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['path', 'extension', 'base_name'], 'string', 'max' => 255],
        ];

        if ($this->fileRule) {
            $rules[] = $this->fileRule;
        } else {
            $rules[] = ['file', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 5 * 1024 * 1024, 'skipOnEmpty' => false, 'on' => self::SCENARIO_IMAGE];
            $rules[] = ['file', 'file', 'extensions' => ['pdf', 'txt', 'doc'], 'maxSize' => 4 * 1024 * 1024, 'skipOnEmpty' => false, 'on' => self::SCENARIO_DOCUMENT];
        }

        return $rules;
    }

    /**
     * @param bool $save
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload(bool $save = true): bool
    {
        $file = $this->file;

        $name = sha1($file->baseName . time());
        $path = $this->uploadPath . substr($name, 0, 2)
            . DIRECTORY_SEPARATOR . substr($name, 2, 2)
            . DIRECTORY_SEPARATOR . substr($name, 4)
            . DIRECTORY_SEPARATOR;

        $this->base_name = $file->baseName;
        $this->path = $path;
        $this->extension = $file->extension;

        if (!$this->validate()) {
            return false;
        }

        FileHelper::createDirectory(Yii::getAlias($this->basePath . $path));

        if (!$file->saveAs(Yii::getAlias($this->basePath . $path) . self::FILE_NAME_ORIGINAL . '.' . $this->extension)) {
            return false;
        };

        if ($save) {
            return $this->save(false);
        }

        return true;
    }

    /**
     * @return false|int|void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete()
    {
        FileHelper::removeDirectory($this->fullPath);

        parent::delete();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'path' => Yii::t('common', 'Path'),
            'status' => Yii::t('common', 'Status'),
            'extension' => Yii::t('common', 'Mime Type'),
            'base_name' => Yii::t('common', 'Name'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
        ];
    }
}
