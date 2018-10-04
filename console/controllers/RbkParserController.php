<?php

namespace console\controllers;

use common\models\File;
use common\models\Post;
use console\components\parsers\RbkParser;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\FileHelper;

class RbkParserController extends Controller
{
    public $limit = 15;

    public function options($actionID)
    {
        return ['limit'];
    }

    public function optionAliases()
    {
        return ['l' => 'limit'];
    }

    /**
     * Parser for rbk.ru
     *
     * @throws \yii\httpclient\Exception
     */
    public function actionIndex()
    {
        $parser = new RbkParser($this->limit);
        $parser->run();

        if (!$parser->hasErrors()) {
            foreach ($parser->parsePosts() as $post) {
                try {
                    $this->savePost($post);
                } catch (\Exception $e) {
                    $this->stderr($e->getLine());
                    $this->stderr(' ');
                    $this->stderr($e->getMessage());
                    $this->stdout("\r\n");
                }
            };
        }

        if ($parser->hasErrors()) {
            foreach ($parser->errors as $error) {
                $this->stderr($error);
            }
        }

        $this->stdout('done');
    }

    /**
     * Parser for rbk.ru
     *
     * @throws \yii\httpclient\Exception
     */
    public function actionTest()
    {
        foreach (\api\models\Post::find()->all() as $post) {

            echo mb_substr($post->content, 0, 200);
            echo "\r\n";
            echo "\r\n";
            echo "\r\n";
        }
    }

    /**
     * @param array $post
     *
     * @throws Exception
     */
    private function savePost(array $post)
    {
        if (isset($post['image_link'])) {
            try {
                $image_id = $this->saveFile($post['image_link']);
            } catch (\Exception $e) {
                $this->stderr($e->getLine());
                $this->stderr(' ');
                $this->stderr($e->getMessage());
                $this->stdout("\r\n");
            }
        }

        if (!$post['title']) {
            throw new Exception('Title is not defined');
        }

        $post = new Post([
            'title' => $post['title'],
            'description' => $post['description'] ?? '',
            'content' => $post['content'] ?? '',
            'image_id' => $image_id ?? null,
        ]);

        if (!$post->save()) {
            throw new Exception(implode('; ', $post->firstErrors));
        };
    }

    /**
     * @param $url
     * @return int
     * @throws Exception
     * @throws \yii\base\Exception
     */
    private function saveFile($url): int
    {
        $basePath = \Yii::getAlias('@api/web/uploads/');
        $array = explode('.', $url);
        $extension = array_pop($array);

        $name = sha1(mt_rand(0, 100) .  time());
        $baseName = substr($name, 4);

        $path = substr($name, 0, 2)
            . DIRECTORY_SEPARATOR . substr($name, 2, 2)
            . DIRECTORY_SEPARATOR . substr($name, 4)
            . DIRECTORY_SEPARATOR;

        FileHelper::createDirectory($basePath . $path);

        $fullPath = $basePath . $path . $baseName . '.' . $extension;

        if (file_put_contents($fullPath, file_get_contents($url)) === false) {
            throw new Exception('Cannot get file from url');
        };

        $file = new File([
            'path' => $path,
            'status' => File::STATUS_ACTIVE,
            'extension' => $extension,
            'base_name' => $baseName,
        ]);

        if (!$file->save()) {
            throw new Exception(implode('; ', $file->firstErrors));
        };

        return $file->id;
    }
}
