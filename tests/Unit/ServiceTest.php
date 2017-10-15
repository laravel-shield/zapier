<?php

namespace Shield\Zapier\Test\Unit;

use PHPUnit\Framework\Assert;
use Shield\Shield\Contracts\Service;
use Shield\Testing\TestCase;
use Shield\Zapier\Zapier;

/**
 * Class ServiceTest
 *
 * @package \Shield\Zapier\Test\Unit
 */
class ServiceTest extends TestCase
{
    /**
     * @var \Shield\Zapier\Zapier
     */
    protected $service;

    protected function setUp()
    {
        parent::setUp();

        $this->service = new Zapier;
    }

    /** @test */
    public function it_is_a_service()
    {
        Assert::assertInstanceOf(Service::class, new Zapier);
    }

    /** @test */
    public function it_can_verify_a_valid_request()
    {
        $this->app['config']['shield.services.zapier.options.username'] = 'username';
        $this->app['config']['shield.services.zapier.options.password'] = 'password';

        $request = $this->request();

        $headers = [
            'PHP-AUTH-USER' => 'username',
            'PHP-AUTH-PW' => 'password',
        ];

        $request->headers->add($headers);

        Assert::assertTrue($this->service->verify($request, collect($this->app['config']['shield.services.zapier.options'])));
    }

    /** @test */
    public function it_will_not_verify_a_bad_request()
    {
        $this->app['config']['shield.services.zapier.options.username'] = 'user';
        $this->app['config']['shield.services.zapier.options.password'] = 'pass';

        $request = $this->request();

        $headers = [
            'PHP-AUTH-USER' => 'user',
            'PHP-AUTH-PW' => 'wrong-pass',
        ];

        $request->headers->add($headers);

        Assert::assertFalse($this->service->verify($request, collect($this->app['config']['shield.services.zapier.options'])));
    }

    /** @test */
    public function the_headers_are_not_important()
    {
        Assert::assertArraySubset([], $this->service->headers());
    }
}
