<?php
/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2015 Xibo Signage Ltd
 */
namespace XiboTests;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /** @var  \Xibo\Platform\Provider\XiboPlatform */
    protected $provider;

    /**
     * Get Provider
     * @return \Xibo\Platform\Provider\XiboPlatform
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set up for each test
     * @throws \Exception
     */
    protected function setUp()
    {
        // Connect to the API
        $clientId = getenv('XIBO_PLATFORM_CLIENT_ID');
        $clientSecret = getenv('XIBO_PLATFORM_CLIENT_SECRET');

        if (!$clientId || !$clientSecret)
            throw new \Exception('Environment not configured for testing');

        // Monolog (requires dev composer dependencies)
        $handlers = [
            new \Monolog\Handler\StreamHandler('phpunit.log')
        ];
        $processors = [
            new \Monolog\Processor\UidProcessor()
        ];

        $log = new \Monolog\Logger('PLATFORM-API', $handlers, $processors);

        $this->provider = new \Xibo\Platform\Provider\XiboPlatform([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'mode' => 'TEST',
            'urlOverride' => getenv('XIBO_PLATFORM_URL')
        ], [
            'logger' => $log
        ]);
    }
}