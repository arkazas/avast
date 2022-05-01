<?php

namespace App\Classes\Factory;

use App\Classes\Reader\ReaderInterface;
use App\Classes\Reader\XmlReader;
use Symfony\Component\String\Exception\InvalidArgumentException;

class ReaderFactory {
    /**
     * @param string $param
     * @return ReaderInterface
     */
    static public function get(string $param): ReaderInterface {
        switch ($param) {
            case "xml": return new XmlReader();
            default: throw new InvalidArgumentException("Wrong file extension. The system support only the next formats: xml");
        };
    }
}