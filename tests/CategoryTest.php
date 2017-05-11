<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase

{
    use DatabaseMigrations;

    /** @test */
    function a_category_has_items()
    {
    	$category = factory('App\Category')->create();

    	$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $category->items);
    }

    /** @test */
    function a_category_can_add_an_item()
    {
    	$category = factory('App\Category')->create();

    	$category->addItem(['name' => 'foo']);

    	$this->assertCount(1, $category->items);
    }
}