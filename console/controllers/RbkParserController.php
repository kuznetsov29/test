<?php

namespace console\controllers;

use console\components\parsers\RbkParser;
use yii\console\Controller;

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

            };
        }

        if ($parser->hasErrors()) {
            foreach ($parser->errors as $error) {
                $this->stderr($error);
            }
        }

        $this->stdout('done');
    }
}
