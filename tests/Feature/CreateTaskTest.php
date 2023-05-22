<?php

namespace Tests\Feature;

use App\Traits\TestsTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;
    use TestsTrait;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->artisan('db:seed');
    }

    /**
     * A basic test example.
     */
    public function testCreateTask(): void
    {
        $user = $this->getUser();
        $token = $this->getUserToken($user);
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->post('/api/task/store', $this->fakeTaskStoreData());
        $response
            ->assertStatus(200)
            ->assertJsonIsObject('data')
            ->assertJsonStructure([
                'data'  => [
                    'id',
                    'title',
                    'description',
                    'due_date',
                    'status'
                ],
                'message'
            ]);
    }

    public function testCreateTaskValidationError(): void
    {
        $user = $this->getUser();
        $token = $this->getUserToken($user);
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->post('/api/task/store', $this->wrongFakeTaskStoreData());
        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'data',
                'message'
            ]);
    }
}