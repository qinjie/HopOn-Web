<?php
namespace tests\codeception\api;
use tests\codeception\api\FunctionalTester;

class RentalCest
{
    private $accessToken;

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function testGetBookingHistory(FunctionalTester $I)
    {
        $I->wantTo('get booking history');
        $this->accessToken = $I->login('1111', '123456')->token;
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('rental/history');
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->seeResponseMatchesJsonType([
            'rental_id' => 'string',
            'booking_id' => 'string',
            'bicycle_id' => 'string',
            'bicycle_serial' => 'string',
            'desc' => 'string',
            'brand' => 'string',
            'model' => 'string',
            'pickup_station_name' => 'string',
            'pickup_station_address' => 'string',
            'pickup_station_postal' => 'string',
            'pickup_station_lat' => 'string',
            'pickup_station_lng' => 'string',
            'book_at' => 'string',
            'pickup_at' => 'null|string',
            'return_at' => 'string',
            'duration' => 'string',
            'return_station_name' => 'string',
            'return_station_address' => 'string',
            'return_station_postal' => 'string',
            'return_station_lat' => 'string',
            'return_station_lng' => 'string',
        ], '$[*]');
    }
}
