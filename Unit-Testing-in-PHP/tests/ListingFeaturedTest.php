<?php

use PHPUnit\Framework\TestCase;

class ListingFeaturedTest extends TestCase
{
    /** @test */
    function getStatusReturnsFeatured()
    {
        $listing_featured = new ListingFeatured(['id'=>1, 'title'=>'title']);
        $this->assertEquals('featured', $listing_featured->getStatus());
    }

    /** @test */
    function getCocReturnsValidCoc()
    {
        $listing_featured = new ListingFeatured(['id'=>1, 'title'=>'title', 'coc'=>'code of conduct']);
        $this->assertEquals('code of conduct', $listing_featured->getCoc());
    }
}
