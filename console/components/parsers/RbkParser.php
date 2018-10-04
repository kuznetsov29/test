<?php

namespace console\components\parsers;

use Symfony\Component\DomCrawler\Crawler;
use yii\base\BaseObject;
use yii\httpclient\Client;
use yii\httpclient\Response;

/**
 * @property array $errors
 *
 * Class RbkParser
 * @package console\components\parsers
 */
class RbkParser extends BaseObject
{
    const URL = 'http://rbk.ru';

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var array
     */
    private $links = [];

    /**
     * @var array
     */
    private $limit;

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param int $limit
     *
     * RbkParser constructor.
     */
    public function __construct(int $limit)
    {
        $this->limit = $limit;

        parent::__construct([]);
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->errors !== [];
    }

    /**
     * @return bool
     * @throws \yii\httpclient\Exception
     */
    public function run()
    {
        $client = new Client();
        $response = $client->get(self::URL)->send();

        if ($response->isOk) {
            $this->getPostLinks($response);
        } else {
            $this->errors[] = 'Cannot get page ' .  self::URL;
        }
    }

    /**
     * @param Response $response
     */
    protected function getPostLinks(Response $response)
    {
        $html = $response->getContent();
        $crawler = new Crawler($html);

        $crawler = $crawler->filter('a.news-feed__item');
        $crawler = $crawler->filterXPath("//a[not(contains(@href,'utm_source'))]");

        for ($i = 0; $i < 15 && $i < $crawler->count(); $i++) {
            $this->links[] = $crawler
                ->getNode($i)
                ->getAttribute('href');
        }
    }

    /**
     * @return \Generator
     */
    public function parsePosts()
    {
        foreach ($this->links as $link) {
            $client = new Client();

            try {
                $response = $client->get($link)->send();
            } catch (\yii\httpclient\Exception $e) {
                $this->errors[] = '\yii\httpclient\Exception. Cannot get page ' .  $link;
                continue;
            }

            if (!$response->isOk) {
                $this->errors[] = 'Cannot get page ' .  $link;
                continue;
            }

            yield $this->parsePost($response);
        }
    }

    /**
     * @param Response $response
     * @return array
     */
    private function parsePost(Response $response): array
    {
        $html = $response->getContent();
        $crawler = new Crawler($html);

        $title = $crawler->filter('div.article__header__title');
        $articleText = $crawler->filter('div.article__text');
        $description = $articleText->filter('div.article__text__overview');

        if ($title->count()) {
            var_dump(trim($title->first()->text()));
        }

        if ($description->count()) {
            var_dump(trim($description->first()->text()));
        }

        return [];


//        foreach ($crawler as $domElement) {
//            $this->links[] = $domElement->getAttribute('href');
//        }
    }
}