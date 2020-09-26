<?php

use PHPUnit\Framework\TestCase;

class ListingBasicTest extends TestCase
{
    /** @test */
    function listingBasicMustHaveData()
    {
        $this->expectExceptionMessage('Unable to create a listing, data unavailable');
        $listing_basic = new ListingBasic();
    }

    /** @test */
    function dataMustHaveValidId()
    {
        $this->expectExceptionMessage('Unable to create a listing, invalid id');
        $listing_basic = new ListingBasic(['s']);
    }

    /** @test */
    function dataMustHaveValidTitle()
    {
        $this->expectExceptionMessage('Unable to create a listing, invalid title');
        $listing_basic = new ListingBasic(['id'=>1]);
    }

    /** @test */
    function canBeCreatedWithIdAndTitle()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title']);
        $this->assertInstanceOf('ListingBasic', $listing_basic);
    }

    /** @test */
    function getStatusReturnsBasic()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title']);
        $this->assertEquals('basic', $listing_basic->getStatus());
    }

    /** @test */
    function getIdReturnsValidId()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title']);
        $this->assertEquals(1, $listing_basic->getId());
    }

    /** @test */
    function getTitleReturnsValidTitle()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title']);
        $this->assertEquals('title', $listing_basic->getTitle());
    }

    /** @test */
    function getWebsiteReturnsValidWebsite()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title', 'website'=>'http://www.example.com']);
        $this->assertEquals('http://www.example.com', $listing_basic->getWebsite());
    }

    /** @test */
    function getEmailReturnsValidEmail()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title', 'email'=>'example@example.com']);
        $this->assertEquals('example@example.com', $listing_basic->getEmail());
    }

    /** @test */
    function getTwitterReturnsValidTwitter()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title', 'twitter'=>'example']);
        $this->assertEquals('example', $listing_basic->getTwitter());
    }

    /** @test */
    function toArrayReturnsValidArray()
    {
        $listing_basic = new ListingBasic(['id'=>'1', 'title'=>'title', 'website'=>'http://www.example.com', 'email'=>'example@example.com', 'twitter'=>'example']);
        $this->assertEquals(['id'=>1, 'title'=>'title', 'website'=>'http://www.example.com', 'email'=>'example@example.com', 'twitter'=>'example', 'status'=>'basic'], $listing_basic->toArray());
    }

    /** @test */
    function emptyWebsiteReturnsNull()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title', 'website'=>'']);
        $this->assertEquals(null, $listing_basic->getWebsite());
    }

    /** @test */
    function setWebsiteAddsHttp()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title', 'website'=>'www.example.com']);
        $this->assertEquals('http://www.example.com', $listing_basic->getWebsite());
    }

    /** @test */
    function emptyStatusReturnsBasic()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title', 'status'=>'']);
        $this->assertEquals('basic', $listing_basic->getStatus());
    }

    /** @test */
    function setStatusReturnsValidStatus()
    {
        $listing_basic = new ListingBasic(['id'=>1, 'title'=>'title', 'status'=>'status']);
        $this->assertEquals('status', $listing_basic->getStatus());
    }
}
