<?php

namespace YameteTests\Driver;


class OverwatchPornPro extends \PHPUnit\Framework\TestCase
{
    public function testDownload()
    {
        $url = 'http://www.overwatchporn.pro/galleries/friend-request-3259';
        $driver = new \Yamete\Driver\OverwatchPornPro();
        $driver->setUrl($url);
        $this->assertTrue($driver->canHandle());
        $this->assertEquals(9, count($driver->getDownloadables()));
    }
}
