<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ListingTest extends TestCase
{
	use DatabaseMigrations;

	protected $listing;

	public function setUp()
		{
			parent::setUp();
			$this->listing = factory('App\Listing')->create();
		}	

	/** @test */
	function a_listing_consists_of_items()
	{
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->listing->items);
	}

	/** @test */
	function a_listing_can_add_an_item()
	{
		$item = factory('App\Item')->create();

		$this->listing->addItem($item);

		$this->assertCount(1, $this->listing->items);	
	}
}