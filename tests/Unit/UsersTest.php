<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    /**
     * @var UserRepository|(UserRepository&\Mockery\LegacyMockInterface)|(UserRepository&\Mockery\MockInterface)|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $userRepository;
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->userRepository = \Mockery::mock(UserRepository::class);
        $this->userService = new UserService($this->userRepository);
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        \Mockery::close();
    }

    /**
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function testTask()
    {
        $userData = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        // Mock the login method of the UserRepository
        $this->userRepository
            ->shouldReceive('login')
            ->once()
            ->with($userData)
            ->andReturn(new User());

        // Mock the Hash::check method
        Hash::shouldReceive('check')
            ->once()
            ->with($userData['password'], \Mockery::type(User::class)->password)
            ->andReturn(true);
        $user = $this->userService->login($userData);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function testFailedLogin()
    {
        $userData = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        // Mock the login method of the UserRepository
        $this->userRepository
            ->shouldReceive('login')
            ->once()
            ->with($userData)
            ->andReturn(null);

        $user = $this->userService->login($userData);

        $this->assertEquals(null, $user);
    }

    /**
     * @return void
     */
    public function testUserCanRegister()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        // Mock the register method of the UserRepository
        $this->userRepository
            ->shouldReceive('register')
            ->once()
            ->with($userData)
            ->andReturn(new User());

        $user = $this->userService->register($userData);

        $this->assertInstanceOf(User::class, $user);
    }

    /** @test */
    public function testUserCanGetProfile()
    {
        $user = new User();

        // Mock the request()->user() method
        $this->mockRequestUser($user);

        $profile = $this->userService->profile();

        $this->assertInstanceOf(User::class, $profile);
        $this->assertSame($user, $profile);
    }

    // Helper method to mock the request()->user() method

    /**
     * @param $user
     * @return void
     */
    protected function mockRequestUser($user)
    {
        app()->instance('request', \Mockery::mock('Illuminate\Http\Request', function ($mock) use ($user) {
            $mock->shouldReceive('user')->andReturn($user);
        }));
    }
}
