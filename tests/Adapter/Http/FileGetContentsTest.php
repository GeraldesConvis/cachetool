<?php

namespace CacheTool\Adapter\Http;

use CacheTool\Adapter\Http\FileGetContents;

class FileGetContentsTest extends \PHPUnit\Framework\TestCase
{
    use BuiltInHttpServerTrait;

    public function testFetch()
    {
        $client = new FileGetContents(self::getBaseUrl());
        $this->assertStringStartsWith('# CacheTool', $client->fetch('README.md'));
    }

    public function testFetchUnderscores()
    {
        $sslipHostname = '_.127.0.0.1.sslip.io';
        if (!gethostbynamel($sslipHostname)) {
            $this->markTestSkipped(
                "{$sslipHostname} does not resolve, sslip  DNS is not configured correctly, skipping."
            );
        }
        $client = new SymfonyHttpClient("http://{$sslipHostname}:" . self::getServerPort());
        $this->assertStringStartsWith('# CacheTool', $client->fetch('README.md'));
    }

    public function testFetchFailed()
    {
        $client = new FileGetContents(self::getBaseUrl());
        $result = unserialize($client->fetch('does-not-exist'));

        $this->assertIsArray($result);
        $this->assertEquals(false, $result['result']);
        $this->assertCount(1, $result['errors']);
    }
}
