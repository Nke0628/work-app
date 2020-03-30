<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * @test
     */
    public function トップページを表示する()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
