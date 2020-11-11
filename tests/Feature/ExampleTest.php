<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * Recuperando usuarios
     *
     * @return void
     */
    public function testGettingUsers()
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
    }
}
