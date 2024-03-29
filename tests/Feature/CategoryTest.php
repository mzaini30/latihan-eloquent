<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Scopes\IsActiveScope;
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

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);
        $category = Category::find(1);
        $category->name = "Food update";
        $result = $category->update();
        self::assertTrue($result);
    }
    public function testSelect()
    {
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->name = "Category "  . $i;
            $category->save();
        }
        $categories = Category::whereNull("description")->get();
        self::assertEquals(5, $categories->count());
        $categories->each(function ($category) {
            $category->description = "updated";
            $category->update();
        });
    }
    public function testUpdateMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "name" => "Name $i"
            ];
        }
        $result = Category::insert($categories);
        self::assertTrue($result);
        Category::whereNull("description")->update([
            "description" => "Updated"
        ]);
        $total = Category::where("description", "Updated")->count();
        self::assertEquals(10, $total);
    }
    public function testDelete()
    {
        $this->seed(CategorySeeder::class);
        $category = Category::find(1);
        $result = $category->delete();
        self::assertTrue($result);
        $total = Category::count();
        self::assertEquals(0, $total);
    }
    public function testDeleteMany()
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
        Category::whereNull("description")->delete();
        $total = Category::count();
        self::assertEquals(0, $total);
    }
    public function testRemoveGlobalScope()
    {
        $category = new Category();
        $category->id = 1000;
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = false;
        $category->save();
        $category = Category::find(1000);
        self::assertNull($category);
        $category = Category::withoutGlobalScopes([IsActiveScope::class])->find(1000);
        self::assertNotNull($category);
    }
}
