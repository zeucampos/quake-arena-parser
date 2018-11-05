<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentTest extends TestCase
{
    /**
     * @return void
     */
    public function testBasicExample()
    {
        $obj = [
            'id' => 0,
            'total_kills' => 0,
            'players' => [],
            'kills' => [],
            'kills_by_means' => []
        ];
        $response = $this->json('POST', '/game-test', $obj);

        $response
            ->assertStatus(201)
            ->assertJson([
                'id' => 0,
                'total_kills' => 0,
                'players' => [],
                'kills' => [],
                'kills_by_means' => []
            ]);
    }
}
