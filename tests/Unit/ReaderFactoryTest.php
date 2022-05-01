<?php

namespace Tests\Unit;

use App\Classes\Factory\ReaderFactory;
use App\Classes\Reader\XmlReader;
use Symfony\Component\String\Exception\InvalidArgumentException;
use Tests\BaseTestCase;

class ReaderFactoryTest extends BaseTestCase
{
    /**
     * @covers \App\Classes\Factory\ReaderFactory::get
     */
    public function testCreateXmlReader()
    {
        $xmlReader = ReaderFactory::get('xml');
        $this->assertIsObject($xmlReader);
        $this->assertTrue($xmlReader instanceof XmlReader);
    }

    /**
     * @covers \App\Classes\Factory\ReaderFactory::get
     */
    public function testCreateNonXmlReader()
    {
        $this->expectException(InvalidArgumentException::class);
        ReaderFactory::get('csv');
    }
}