<?php
namespace tests\codeception\api;

use Yii;
use tests\codeception\api\FunctionalTester;
use Codeception\Util\Debug;

class UserCest
{
    private $token;

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function login(FunctionalTester $I)
    {
        $I->wantTo('login');
        $I->sendPOST('user/login', [
            'username' => '1111',
            'password' => '123456'
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'user_id' => 'integer',
            'auth_key' => 'string',
            'token' => 'string',
            'fullname' => 'string'
        ]);
        $response = json_decode($I->grabResponse());
        $this->token = $response->token;
    }

    public function getProfile(FunctionalTester $I)
    {
        $I->wantTo('get my profile');
        $I->amBearerAuthenticated($this->token);
        $I->sendGET('user/profile');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'fullname' => 'string',
            'email' => 'string:email',
            'mobile' => 'string'
        ]);
    }
}
