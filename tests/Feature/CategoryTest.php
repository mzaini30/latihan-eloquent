<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testInsert()
    {
        $category = new Category();
        $category->name = "Gadget";
        $result = $category->save();
        assertTrue($result);
    }
    public function testInsertManyCategories()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "name" => "Name $i"
            ];
        }
        $result = Category::insert($categories);
        self::assertTrue($result);
        $total = Category::count();
        self::assertEquals(10, $total);
    }
    public function testFind()
    {
        $this->seed(CategorySeeder::class);
        $category = Category::find(14);
        self::assertNotNull($category);
        self::assertEquals("Food", $category->name);
    }
}
