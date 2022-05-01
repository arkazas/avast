<?php

namespace App\Classes\Reader;

use IteratorAggregate;
use Symfony\Component\DomCrawler\Crawler;

class XmlReader implements ReaderInterface
{
    /**
     * @var string
     */
    protected string $fileName;

    /**
     * @var IteratorAggregate
     */
    protected IteratorAggregate $parser;

    /**
     * @param string $pattern
     * @return array
     */
    public function getCustomDataAsArray(string $pattern): array
    {
        $result = [];
        $this->parser->filterXPath($pattern)->each(function (Crawler $node) use (&$result) {
            $key = sprintf("cookie:%s:%s", $node->attr('name'), $node->attr('host')) ;
            $result[$key] = $node->text();
        });

        return $result;
    }

    /**
     * @param string $pattern
     * @return array
     */
    public function getNodesContentAsArray(string $pattern): array
    {
        return $this->parser->filterXPath($pattern)->each(function ($node) {
            return $node->text();
        });
    }

    /**
     * @param IteratorAggregate $parser
     * @return XmlReader
     */
    public function setParser(IteratorAggregate $parser): self
    {
        $this->parser = $parser;

        return $this;
    }
}