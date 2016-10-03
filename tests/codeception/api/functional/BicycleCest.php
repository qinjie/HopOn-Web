<?php
namespace tests\codeception\api;
use tests\codeception\api\FunctionalTester;
use api\modules\v1\models\Bicycle;
use api\modules\v1\models\Feedback;

class BicycleCest
{
    private $accessToken;
    private $bookedBicycleId;
    private $rentalId;
    
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function testBookBicycle(FunctionalTester $I)
    {
        $I->wantTo('book a bicycle');
        $this->accessToken = $I->login('1111', '123456')->token;
        $I->amBearerAuthenticated($this->accessToken);
        $I->seeInDatabase('bicycle', [
            'serial' => 'SG11111',
            'station_id' => 1,
            'bicycle_type_id' => 1,
            'status' => Bicycle::STATUS_FREE,
        ]);
        $I->sendPOST('bicycle/book', [
            'stationId' => 1,
            'bicycleTypeId' => 1,
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeInDatabase('bicycle', [
            'serial' => 'SG11111',
            'status' => Bicycle::STATUS_BOOKED,
        ]);
        $response = json_decode($I->grabResponse());
        $this->bookedBicycleId = $response->id;
        $I->seeResponseContainsJson([
            'serial' => 'SG11111',
            'bicycle_type_id' => 1,
            'station_id' => 1,
            'status' => Bicycle::STATUS_BOOKED,
        ]);
    }

    public function testCurrentBookingInfo(FunctionalTester $I)
    {
        $I->wantTo('get current booking information');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('rental/current-booking');
        $I->seeResponseCodeIs(200);
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
            'pickup_at' => 'null',
            'beacon_station_uuid' => 'string',
            'beacon_station_major' => 'string',
            'beacon_station_minor' => 'string',
            'beacon_bicycle_uuid' => 'string',
            'beacon_bicycle_major' => 'string',
            'beacon_bicycle_minor' => 'string',
            'bean_bicycle_name' => 'string',
            'bean_bicycle_address' => 'string',
            'status' => 'string',
            'listImageUrl' => ['string:url'],
            'user_id' => 'integer',
            'auth_key' => 'string',
            'enc' => 'string',
        ]);
        $response = json_decode($I->grabResponse());
        $this->rentalId = $response->rental_id;
    }

    public function testUnlockBicycle(FunctionalTester $I)
    {
        $I->wantTo('unlock a bicycle');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('bicycle/unlock', [
            'bicycleId' => $this->bookedBicycleId,
            'latitude' => 1.5,
            'longitude' => 105,
        ]);
        $I->seeInDatabase('bicycle', [
            'serial' => 'SG11111',
            'status' => Bicycle::STATUS_UNLOCKED,
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType([
            'book_at' => 'string',
            'pickup_at' => 'string',
            'return_at' => 'null',
        ]);
    }

    public function testLockBicycle(FunctionalTester $I)
    {
        $I->wantTo('lock a bicycle');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('bicycle/lock', [
            'bicycleId' => $this->bookedBicycleId,
            'latitude' => 1.5,
            'longitude' => 105,
        ]);
        $I->seeInDatabase('bicycle', [
            'serial' => 'SG11111',
            'status' => Bicycle::STATUS_LOCKED,
        ]);
        $I->seeResponseCodeIs(200);
    }

    public function testReturnBicycle(FunctionalTester $I)
    {
        $I->wantTo('return a bicycle');
        $I->amBearerAuthenticated($this->accessToken);
        $beaconId = $I->grabFromDatabase('station', 'beacon_id', [
            'id' => 1,
        ]);
        $beaconUUID = $I->grabFromDatabase('beacon', 'uuid', [
            'id' => $beaconId,
        ]);
        $beaconMajor = $I->grabFromDatabase('beacon', 'major', [
            'id' => $beaconId,
        ]);
        $beaconMinor = $I->grabFromDatabase('beacon', 'minor', [
            'id' => $beaconId,
        ]);
        $I->sendPOST('bicycle/return', [
            'bicycleId' => $this->bookedBicycleId,
            'latitude' => 1.5,
            'longitude' => 105,
            'listBeacons' => [
                [
                    'uuid' => $beaconUUID,
                    'major' => $beaconMajor,
                    'minor' => $beaconMinor,
                    'rssi' => -10,
                ]
            ],
        ]);
        $I->seeInDatabase('bicycle', [
            'serial' => 'SG11111',
            'status' => Bicycle::STATUS_FREE,
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType([
            'book_at' => 'string',
            'pickup_at' => 'string',
            'return_at' => 'string',
        ]);
        $I->seeResponseContainsJson([
            'serial' => 'SG11111',
            'return_station_id' => 1,
        ]);
    }

    public function testSubmitFeedbackAfterReturn(FunctionalTester $I)
    {
        $I->wantTo('provide feedback after returning bicycle');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('feedback/new', [
            'rentalId' => $this->rentalId,
            'listIssue' => [
                Feedback::ISSUE_BREAK_NOT_EFFECTIVE,
                Feedback::ISSUE_TYRE_FLAT,
            ],
            'comment' => 'a test comment',
            'rating' => 4.5,
        ]);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertEquals('Feedback saved', $response);
    }
}
