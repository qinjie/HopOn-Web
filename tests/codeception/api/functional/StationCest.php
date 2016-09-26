<?php
namespace tests\codeception\api;
use tests\codeception\api\FunctionalTester;

class StationCest
{
    private $accessToken;
    private $listStation;

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function testSearchStation(FunctionalTester $I)
    {
        $I->wantTo('search nearest stations');
        $this->accessToken = $I->login('1111', '123456')->token;
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('station/search', [
            'latitude' => 1.339835,
            'longitude' => 103.776095,
        ]);
        $response = json_decode($I->grabResponse());
        $this->listStation = $response;
        $I->assertLessThanOrEqual(10, count($response));
        codecept_debug($response);
        $I->seeResponseMatchesJsonType([
            'id' => 'string',
            'name' => 'string',
            'address' => 'string',
            'latitude' => 'string',
            'longitude' => 'string',
            'postal' => 'string',
            'bicycle_count' => 'string',
            'available_bicycle' => 'string',
            'distanceText' => 'string',
            'distanceValue' => 'integer',
        ], '$[*]');
    }

    public function testGetStationDetail(FunctionalTester $I)
    {
        $I->wantTo('get station detail by id');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('station/detail', [
            'stationId' => $this->listStation[0]->id,
        ]);
        $response = json_decode($I->grabResponse());
        $I->assertGreaterThanOrEqual(1, count($response));
        codecept_debug($response);
        $I->seeResponseMatchesJsonType([
            'bicycle_type_id' => 'string',
            'brand' => 'string',
            'model' => 'string',
            'desc' => 'string',
            'availableBicycle' => 'string',
            'totalBicycle' => 'string',
            'listImageUrl' => ['string:url'],
        ], '$[*]');
    }
}
