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

    public function testChangePassword(FunctionalTester $I)
    {
        $token = $I->login('1111', '123456')->token;
        $I->wantTo('change password');
        $I->amBearerAuthenticated($token);
        $I->sendPOST('user/change-password', [
            'oldPassword' => '123456',
            'newPassword' => '654321',
        ]);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertEquals($response, 'change password successfully');

        $I->sendPOST('user/change-password', [
            'oldPassword' => '654321',
            'newPassword' => '123456',
        ]);
    } 

    public function testChangeEmail(FunctionalTester $I)
    {
        $token = $I->login('1111', '123456')->token;
        $I->wantTo('change email');
        $I->amBearerAuthenticated($token);
        $I->sendPOST('user/change-email', [
            'newEmail' => '123456@mail.com',
            'password' => '123456',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType([
            'email' => 'string',
        ]);
        $I->seeResponseContainsJson([
            'email' => '123456@mail.com',
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

    public function testChangeMobilePhone(FunctionalTester $I)
    {
        $token = $I->login('1111', '123456')->token;
        $I->wantTo('change mobile phone');
        $I->amBearerAuthenticated($token);
        $I->sendPOST('user/change-mobile', [
            'newMobile' => '88888888',
            'password' => '123456',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType([
            'mobile' => 'string',
        ]);
        $I->seeResponseContainsJson([
            'mobile' => '88888888',
        ]);
    } 
}
