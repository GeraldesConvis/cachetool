<?php

namespace CacheTool\Adapter\Http;

use Symfony\Component\Process\Process;

trait BuiltInHttpServerTrait
{
    private static Process $process;

    private static string $baseUrl;

    private static int $serverPort;

    public static function setUpBeforeClass(): void
    {
        self::$serverPort = self::findAvailablePort();
        self::$baseUrl = 'http://127.0.0.1:' . self::$serverPort;
        self::$process = new Process(['php', '-S', '127.0.0.1:' . self::$serverPort, '-t', dirname(__DIR__, 3)]);
        self::$process->start();

        self::waitForServer();
    }

    public static function tearDownAfterClass(): void
    {
        self::$process->stop();
    }

    private static function findAvailablePort(): int
    {
        $server = @stream_socket_server('tcp://127.0.0.1:0');

        if ($server === false) {
            throw new \RuntimeException('Could not find available port for HTTP test server.');
        }

        $name = stream_socket_get_name($server, false);
        fclose($server);

        if (!is_string($name) || !str_contains($name, ':')) {
            throw new \RuntimeException('Could not determine HTTP test server port.');
        }

        return (int) substr(strrchr($name, ':'), 1);
    }

    private static function waitForServer(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $socket = @fsockopen('127.0.0.1', self::$serverPort, $errno, $errstr, 0.1);

            if ($socket !== false) {
                fclose($socket);
                return;
            }

            if (!self::$process->isRunning()) {
                throw new \RuntimeException('HTTP test server stopped unexpectedly: ' . self::$process->getErrorOutput());
            }

            usleep(100000);
        }

        throw new \RuntimeException('HTTP test server did not start.');
    }

    private static function getBaseUrl(): string
    {
        return self::$baseUrl;
    }

    private static function getServerPort(): int
    {
        return self::$serverPort;
    }
}
