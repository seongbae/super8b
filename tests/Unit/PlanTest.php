<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

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

        $content = $response->getContent();
        $array = json_decode($content, true);

        $data['plan_id'] = $array['id'];
        $data['name'] = 'new name';

        $response = $this->actingAs($user)->json('POST', '/api/plan', $data);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => 'new name',
            ]);
    }

    /**
     * Test to delete a plan
     *
     * @return void
     */
    public function test_can_delete_plan()
    {
        $user = factory(\App\Models\User::class)->create();

        $plan = factory(\App\Models\Plan::class)->create();

        $data = [
            'plan_id' => $plan->id
        ];

        $response = $this->actingAs($user)->json('DELETE', '/api/plan', $data);

        $response
            ->assertStatus(204);
    }

    /**
     * Test to delete a plan
     *
     * @return void
     */
    public function test_can_add_workout_to_plan()
    {
        $user = factory(\App\Models\User::class)->create();

        $planData = [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'user_id' => $user->id,
            'status' => 'published'
        ];

        $workoutData = [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'user_id' => $user->id,
            'status' => 'published'
        ];

        $plan = factory(\App\Models\Plan::class)->create();
        $workout = factory(\App\Models\Workout::class)->create();
       
         $data = [
            'plan_id' => $plan->id,
            'workout_id' => $workout->id
        ];
 
        $response = $this->actingAs($user)->json('POST', '/api/plan/workout', $data);

        $this->assertTrue($plan->workouts->contains($workout));
    }

    // /**
    //  * Test to create a plan
    //  *
    //  * @return void
    //  */
    // public function test_can_publish_plan()
    // {
    //     $data = [
    //         'name' => $this->faker->sentence,
    //         'description' => $this->faker->paragraph,
    //         'user_id' => 1,
    //         'status' => 'draft'
    //     ];

    //     $user = factory(\App\Models\User::class)->create();

    //     $response = $this->actingAs($user)->json('POST', '/api/plan', $data);

    //     $response
    //         ->assertStatus(201)
    //         ->assertJson([
    //             'name' => $data['name'],
    //         ]);
    // }

    // /**
    //  * Test to create a plan
    //  *
    //  * @return void
    //  */
    // public function test_can_unpublish_plan()
    // {
    //     $data = [
    //         'name' => $this->faker->sentence,
    //         'description' => $this->faker->paragraph,
    //         'user_id' => 1,
    //         'status' => 'draft'
    //     ];

    //     $user = factory(\App\Models\User::class)->create();

    //     $response = $this->actingAs($user)->json('POST', '/api/plan', $data);

    //     $response
    //         ->assertStatus(201)
    //         ->assertJson([
    //             'name' => $data['name'],
    //         ]);
    // }
}
