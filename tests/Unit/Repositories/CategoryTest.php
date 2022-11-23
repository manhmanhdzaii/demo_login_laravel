<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Categories;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryTest extends TestCase
{
    protected $category;
    protected $categoryRepository;
    public function setUp(): void
    {
        parent::setUp();
        // chuẩn bị dữ liệu test
        $this->category = new Request();
        $this->category->name = "Manhhhh";
        // khởi tạo lớp CategoryRepository
        $this->categoryRepository = new CategoryRepository(new Categories());
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testStore()
    {
        // Gọi hàm tạo
        $category = $this->categoryRepository->createCategory($this->category);
        // Kiểm tra xem kết quả trả về có là thể hiện của lớp Category hay không
        $this->assertInstanceOf(Categories::class, $category);
        // Kiểm tra data trả về
        $this->assertEquals($this->category->name, $category->name);
        // Kiểm tra dữ liệu có tồn tại trong cơ sở dữ liệu hay không
        $this->assertDatabaseHas('categories', ['name' => $this->category->name]);
    }
    public function testShow()
    {
        $category = Categories::factory()->create();
        $find = $this->categoryRepository->getOne($category->id);
        $this->assertInstanceOf(Categories::class, $find);
        $this->assertEquals($find->name, $category->name);
    }
    public function testUpdate()
    {
        // Tạo dữ liệu mẫu
        $category = Categories::factory()->create();
        $this->category->name = "updateafter";
        $newCategory = $this->categoryRepository->updateCategory($category, $this->category);
        // Kiểm tra dữ liệu trả về
        $this->assertInstanceOf(Categories::class, $newCategory);
        $this->assertEquals($newCategory->name, $this->category->name);
        // Kiểm tra xem cơ sở dữ liệu đã được cập nhập hay chưa
        $this->assertDatabaseHas('categories', ['name' => $this->category->name]);
    }

    public function testDestroy()
    {
        $category = Categories::factory()->create();
        $deleteCategory = $this->categoryRepository->deleteCategory($category);
        // Kiểm tra dữ liệu có trả về true hay không
        if ($deleteCategory == 1) {
            $deleteCategory = true;
        }
        $this->assertTrue($deleteCategory);
        // kiểm tra xem dữ liệu đã được xóa trong cơ sở dữ liệu hay chưa
        $this->assertDatabaseMissing('categories', $category->toArray());
    }
}