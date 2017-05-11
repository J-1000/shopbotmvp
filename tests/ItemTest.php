<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
    use DatabaseMigrations;

    protected $item;

    public function setUp()
    {
        parent::setUp();

        $this->item = factory('App\Item')->create();
    }

    /** @test */
    function an_item_has_a_category()
    {
        $this->assertInstanceOf('App\Category', $this->item->category);
    }
}
