<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PlanTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test to create a plan
     *
     * @return void
     */
    public function test_can_create_plan()
    {
    	$data = [
    		'name' => $this->faker->sentence,
    		'description' => $this->faker->paragraph,
    		'user_id' => 1,
    		'status' => 'draft'
    	];

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->json('POST', '/api/plan', $data);

        $response
    		->assertStatus(201)
    		->assertJson([
                'name' => $data['name'],
            ]);
    }

    /**
     * Test to create a plan
     *
     * @return void
     */
    public function test_can_update_plan()
    {
        $data = [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'user_id' => 1,
            'status' => 'draft'
        ];

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->json('POST', '/api/plan', $data);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => $data['name'],
            ]);
    }

    /**
     * Test to create a plan
     *
     * @return void
     */
    public function test_can_delete_plan()
    {
        $data = [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'user_id' => 1,
            'status' => 'draft'
        ];

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->json('POST', '/api/plan', $data);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => $data['name'],
            ]);
    }

    /**
     * Test to create a plan
     *
     * @return void
     */
    public function test_can_publish_plan()
    {
        $data = [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'user_id' => 1,
            'status' => 'draft'
        ];

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->json('POST', '/api/plan', $data);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => $data['name'],
            ]);
    }

    /**
     * Test to create a plan
     *
     * @return void
     */
    public function test_can_unpublish_plan()
    {
        $data = [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'user_id' => 1,
            'status' => 'draft'
        ];

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->json('POST', '/api/plan', $data);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => $data['name'],
            ]);
    }
}
