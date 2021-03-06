<?php

namespace Yamete\Driver;

class CartoonSexComixCom extends \Yamete\DriverAbstract
{
    const DOMAIN = 'cartoonsexcomix.com';
    private $aMatches = [];

    protected function getDomain()
    {
        return self::DOMAIN;
    }

    public function canHandle()
    {
        return (bool)preg_match(
            '~^https?://www\.(' . strtr($this->getDomain(), ['.' => '\.', '-' => '\-',]) .
            ')/(pictures|gallery|galleries)/(?<album>[^/?]+)[/?]?~',
            $this->sUrl,
            $this->aMatches
        );
    }

    protected function getSelector()
    {
        return '.my-gallery figure a';
    }

    public function getDownloadables()
    {
        $this->sUrl = strpos($this->sUrl, '?') ? substr($this->sUrl, 0, strpos($this->sUrl, '?')) : $this->sUrl;
        $oRes = $this->getClient()->request('GET', $this->sUrl);
        $this->sUrl .= ($this->sUrl{strlen($this->sUrl) - 1} != '/') ? '/' : '';
        $aReturn = [];
        $i = 0;
        foreach ($this->getDomParser()->load((string)$oRes->getBody())->find($this->getSelector()) as $oLink) {
            /* @var \DOMElement $oLink */
            $sFilename = $oLink->getAttribute('href');
            $sBasename = $this->getFolder() . DIRECTORY_SEPARATOR . str_pad($i++, 5, '0', STR_PAD_LEFT)
                . '-' . basename($sFilename);
            $aReturn[$sBasename] = $sFilename;
        }
        return $aReturn;
    }

    private function getFolder()
    {
        return implode(DIRECTORY_SEPARATOR, [$this->getDomain(), $this->aMatches['album']]);
    }
}
