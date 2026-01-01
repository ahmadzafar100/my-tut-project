<?php
declare(strict_types=1);

namespace App\Test\TestCase\Middleware;

use App\Middleware\LoginCheckMiddleware;
use Cake\TestSuite\TestCase;

/**
 * App\Middleware\LoginCheckMiddleware Test Case
 */
class LoginCheckMiddlewareTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Middleware\LoginCheckMiddleware
     */
    protected $LoginCheck;

    /**
     * Test process method
     *
     * @return void
     * @link \App\Middleware\LoginCheckMiddleware::process()
     */
    public function testProcess(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
