<?php
namespace tests\codeception\api;

use Yii;
use tests\codeception\api\FunctionalTester;
use Codeception\Util\Debug;

class UserCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function testLogin(FunctionalTester $I)
    {
        $I->wantTo('login');
        $I->login('1111', '123456');
    }

    public function testGetProfile(FunctionalTester $I)
    {
        $token = $I->login('1111', '123456')->token;
        $I->wantTo('get my profile');
        $I->amBearerAuthenticated($token);
        $I->sendGET('user/profile');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'fullname' => 'string',
            'email' => 'string:email',
            'mobile' => 'string'
        ]);
    }

    public function testLogout(FunctionalTester $I)
    {
        $token = $I->login('1111', '123456')->token;
        $I->wantTo('logout');
        $I->amBearerAuthenticated($token);
        $I->sendGET('user/logout');
        $I->seeResponseCodeIs(200);
    }    
}
