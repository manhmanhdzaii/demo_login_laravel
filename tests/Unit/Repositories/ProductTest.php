<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Products;
use App\Repositories\ProductRepository;

class ProductTest extends TestCase
{

    protected $product;
    protected $productRepository;
    public function setUp(): void
    {
        parent::setUp();
        // chuẩn bị dữ liệu test
        $this->product = [
            'name' => 'Unitest',
            'price' => fake()->numberBetween(100, 900),
            'color_id' => fake()->randomElements([1, 2, 3, 4, 5]),
            'size_id' => fake()->randomElements([1, 2, 3, 4, 5]),
            'category_id' => 3,
            'description' => 'Testing',
        ];
        $this->product = (object)$this->product;
        // khởi tạo lớp ProductRepository
        $this->productRepository = new ProductRepository(new Products());
    }

    public function testStore()
    {
        // Gọi hàm tạo
        $product = $this->productRepository->createProductUnitest($this->product);
        // Kiểm tra xem kết quả trả về có là thể hiện của lớp Product hay không
        $this->assertInstanceOf(Products::class, $product);
        // Kiểm tra data trả về
        $this->assertEquals($this->product->name, $product->name);
        $this->assertEquals($this->product->price, $product->price);
        $this->assertEquals($this->product->category_id, $product->category_id);
        // Kiểm tra dữ liệu có tồn tại trong cơ sở dữ liệu hay không
        $this->assertDatabaseHas('products', ['name' => $this->product->name, 'price' => $this->product->price, 'category_id' => $this->product->category_id]);
    }
    public function testShow()
    {
        $product = Products::factory()->create();
        $find = $this->productRepository->getOne($product->id);
        $this->assertInstanceOf(Products::class, $find);
        $this->assertEquals($find->name, $product->name);
        $this->assertEquals($find->price, $product->price);
        $this->assertEquals($find->category_id, $product->category_id);
    }
    public function testUpdate()
    {
        // Tạo dữ liệu mẫu
        $product = Products::factory()->create();
        $this->product->name = "UpdateUniTest";
        $newProduct = $this->productRepository->updateProductUniTest($product, $this->product);
        // Kiểm tra dữ liệu trả về
        $this->assertInstanceOf(Products::class, $newProduct);
        $this->assertEquals($newProduct->name, $this->product->name);
        $this->assertEquals($newProduct->price, $this->product->price);
        $this->assertEquals($newProduct->category_id, $this->product->category_id);
        // Kiểm tra xem cơ sở dữ liệu đã được cập nhập hay chưa
        $this->assertDatabaseHas('products', ['name' => $this->product->name, 'price' => $this->product->price, 'category_id' => $this->product->category_id]);
    }

    public function testDestroy()
    {
        $product = Products::factory()->create();
        $deleteProduct = $this->productRepository->deleteProduct($product);
        // Kiểm tra dữ liệu có trả về true hay không
        if ($deleteProduct == 1) {
            $deleteProduct = true;
        }
        $this->assertTrue($deleteProduct);
        // kiểm tra xem dữ liệu đã được xóa trong cơ sở dữ liệu hay chưa
        $this->assertDatabaseMissing('products', $product->toArray());
    }
}