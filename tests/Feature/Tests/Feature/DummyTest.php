<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

/**
 * @author Tobias Maxham <git2020@maxham.de>
 */
class DummyTest extends TestCase
{
    protected string $fakeRoute = '/lorem-ipsum-empty-123';

    /** @test **/
    public function it_throws_exceptions()
    {
        $response = $this->post($this->fakeRoute());
        $this->assertEquals(NotFoundHttpException::class, get_class($response->exception));
    }

    /** @test **/
    public function user_needs_to_authenticate()
    {
        Route::get(($fake = $this->fakeRoute()))->middleware('auth');
        $response = $this->get($fake);
        $this->assertTrue(in_array($response->status(), [500, 302]));
    }

    protected function fakeRoute()
    {
        return $this->fakeRoute.Str::random();
    }
}
