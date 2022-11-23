<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\UserRepository;

class UserTest extends TestCase
{
    protected $user;
    protected $userRepository;
    public function setUp(): void
    {
        parent::setUp();
        // chuẩn bị dữ liệu test
        $this->user = [
            'name' => 'Unitest',
            'email' => fake()->unique()->email(),
            'password' => '12345',
            'role' => 'nomal',
            'email_verified_at' => fake()->numberBetween(0, 1),
        ];
        $this->user = (object)$this->user;
        // khởi tạo lớp UserRepository
        $this->userRepository = new UserRepository(new User());
    }

    public function testStore()
    {
        // Gọi hàm tạo
        $user = $this->userRepository->createUser($this->user);
        // Kiểm tra xem kết quả trả về có là thể hiện của lớp User hay không
        $this->assertInstanceOf(User::class, $user);
        // Kiểm tra data trả về
        $this->assertEquals($this->user->name, $user->name);
        $this->assertEquals($this->user->email, $user->email);
        $this->assertEquals($this->user->role, $user->role);
        // Kiểm tra dữ liệu có tồn tại trong cơ sở dữ liệu hay không
        $this->assertDatabaseHas('users', ['name' => $this->user->name, 'email' => $this->user->email, 'role' => $this->user->role]);
    }
    public function testShow()
    {
        $user = User::factory()->create();
        $find = $this->userRepository->getOne($user->id);
        $this->assertInstanceOf(User::class, $find);
        $this->assertEquals($find->name, $user->name);
        $this->assertEquals($find->email, $user->email);
        $this->assertEquals($find->role, $user->role);
    }
    public function testUpdate()
    {
        // Tạo dữ liệu mẫu
        $user = User::factory()->create();
        $this->user->name = "UpdateUniTest";
        $newUser = $this->userRepository->updateUser($user, $this->user);
        // Kiểm tra dữ liệu trả về
        $this->assertInstanceOf(User::class, $newUser);
        $this->assertEquals($newUser->name, $this->user->name);
        $this->assertEquals($newUser->email, $this->user->email);
        $this->assertEquals($newUser->role, $this->user->role);
        // Kiểm tra xem cơ sở dữ liệu đã được cập nhập hay chưa
        $this->assertDatabaseHas('users', ['name' => $this->user->name, 'email' => $this->user->email, 'role' => $this->user->role]);
    }
    public function testDestroy()
    {
        $user = User::factory()->create();
        $deleteUser = $this->userRepository->deleteUser($user);
        // Kiểm tra dữ liệu có trả về true hay không
        if ($deleteUser == 1) {
            $deleteUser = true;
        }
        $this->assertTrue($deleteUser);
        // kiểm tra xem dữ liệu đã được xóa trong cơ sở dữ liệu hay chưa
        $this->assertDatabaseMissing('users', $user->toArray());
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}