<?php

namespace App\Classes\Reader;

use IteratorAggregate;

interface ReaderInterface
{
    /**
     * @param string $pattern
     * @return mixed
     */
    public function getCustomDataAsArray(string $pattern): array;

    /**
     * @param string $pattern
     * @return mixed
     */
    public function getNodesContentAsArray(string $pattern): array;

    /**
     * @param IteratorAggregate $parser
     * @return mixed
     */
    public function setParser(IteratorAggregate $parser): ReaderInterface;
}