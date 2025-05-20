<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Get the URL for a subdomain request.
     *
     * @param string $subdomain
     * @param string $path
     * @return string
     */
    protected function subdomainUrl(string $subdomain, string $path = ''): string
    {
        return "http://{$subdomain}.warga08.test{$path}";
    }
}
