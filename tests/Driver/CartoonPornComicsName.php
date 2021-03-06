<?php

namespace YameteTests\Driver;


class CartoonPornComicsName extends \PHPUnit\Framework\TestCase
{
    public function testDownload()
    {
        $url = 'http://cartoonporncomics.name/content/adult-porn-cartoons/index.html';
        $driver = new \Yamete\Driver\CartoonPornComicsName();
        $driver->setUrl($url);
        $this->assertTrue($driver->canHandle());
        $this->assertEquals(26, count($driver->getDownloadables()));
    }
}
