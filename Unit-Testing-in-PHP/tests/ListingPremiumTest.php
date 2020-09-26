<?php

use PHPUnit\Framework\TestCase;

class ListingPremiumTest extends TestCase
{
    /** @test */
    function getStatusReturnsPremium()
    {
        $listing_premium = new ListingPremium(['id'=>1, 'title'=>'title']);
        $this->assertEquals('premium', $listing_premium->getStatus());
    }

    /** @test */
    function getDescriptionReturnsValidDescription()
    {
        $listing_premium = new ListingPremium(['id'=>1, 'title'=>'title', 'description'=>'description']);
        $this->assertEquals('description', $listing_premium->getDescription());
    }

    /** @test */
    function displayAllowedTagsReturnsValidTags()
    {
        $listing_premium = new ListingPremium(['id'=>1, 'title'=>'title']);
        $this->assertEquals('&lt;p&gt;&lt;br&gt;&lt;b&gt;&lt;strong&gt;&lt;em&gt;&lt;u&gt;&lt;ol&gt;&lt;ul&gt;&lt;li&gt;', $listing_premium->displayAllowedTags());
    }
}
