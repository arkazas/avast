<?php

namespace App\Services;

use App\Classes\Factory\ReaderFactory;
use Exception;
use Redis;
use Symfony\Component\DomCrawler\Crawler;


class AvastService
{
    /**
     * @var string
     */
    protected string $subdomainTag = '//subdomains/subdomain';

    /**
     * @var string
     */
    protected string $cookieTag = '//cookies/cookie';

    /**
     * @var string
     */
    protected string $filePath;

    /**
     * @var string
     */
    protected string $fileContent;

    /**
     * @var Redis
     */
    protected Redis $redisClient;

    /**
     * @param Redis $redisClient
     * @param string $filePath
     */
    public function __construct(Redis $redisClient, string $filePath)
    {
        $this->redisClient = $redisClient;
        $this->filePath = $filePath;
    }

    /**
     * @param bool $isAllKeys
     * @return void
     * @throws Exception
     */
    public function run(bool $isAllKeys)
    {
        if (empty($this->filePath) || !$this->getFileContent()) {
            throw new Exception('File for parsing not found');
        }

        $reader = ReaderFactory::get($this->getFileExtension());
        $subdomains = $reader->setParser($this->getParser())
            ->getNodesContentAsArray($this->subdomainTag);

        $this->cacheData('subdomains', json_encode($subdomains));

        $cookies = $reader->getCustomDataAsArray($this->cookieTag);

        foreach ($cookies as $k => $v) {
            $this->cacheData($k, $v);
        }

        if ($isAllKeys) {
            $this->printAllKeys();
        }
    }

    /**
     * @return void
     */
    protected function printAllKeys(): void
    {
        echo "\n*** Redis keys ***\n";

        foreach ($this->redisClient->keys('*') as $key) {
            echo $key . "\n";
        }
    }

    /**
     * @param string $key
     * @param string $data
     * @return void
     */
    protected function cacheData(string $key, string $data): void
    {
        $this->redisClient->sAdd($key, $data);
    }

    /**
     * @return string
     */
    protected function getFileExtension(): string
    {
        $fileInfo = pathinfo($this->filePath);

        return $fileInfo['extension'];
    }

    /**
     * @return Crawler
     */
    protected function getParser(): Crawler
    {
        return new Crawler($this->getFileContent());
    }

    /**
     * @return string
     */
    protected function getFileContent(): string
    {
        if (empty($this->fileContent)) {
            $this->fileContent = file_get_contents($this->filePath);
        }

        return $this->fileContent;
    }
}