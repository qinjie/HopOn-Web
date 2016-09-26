<?php
namespace tests\codeception\api;
use tests\codeception\api\FunctionalTester;

class SignupCest
{
    private $accessToken;

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {

    }

    public function testSignup(FunctionalTester $I)
    {
        $I->wantTo('sign up');
        $I->sendPOST('user/signup', [
            'fullname' => 'Tan Ah Boy',
            'email' => '123@mail.com',
            'mobile' => '11111111',
            'password' => '123456',
            'role' => 10
        ]);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertEquals($response, 'register successfully');

        $I->seeInDatabase('user', [
            'fullname' => 'Tan Ah Boy',
            'role' => 10,
            'status' => 2,
        ]);
        $userId = $I->grabFromDatabase('user', 'id', [
            'email' => '123@mail.com',
        ]);
        $I->seeInDatabase('user_token', [
            'user_id' => $userId,
            'action' => 1,
        ]);
    }

    public function testResendActivationEmail(FunctionalTester $I) {
        $I->wantTo('resend activation email');
        $I->sendPOST('user/resend-email', [
            'email' => '123@mail.com'
        ]);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertEquals($response, 'resend email');
    }

    public function testActivateUserAfterSignup(FunctionalTester $I) {
        $I->wantTo('activate user after sign up');
        $userId = $I->grabFromDatabase('user', 'id', [
            'email' => '123@mail.com',
        ]);
        $activationToken = $I->grabFromDatabase('user_token', 'token', [
            'user_id' => $userId,
            'action' => 1,
        ]);
        $I->sendPOST('user/activate', [
            'token' => $activationToken,
            'email' => '123@mail.com',
        ]);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->seeResponseMatchesJsonType([
          'token' => 'string',
          'fullname' => 'string',
        ]);
        $this->accessToken = $response->token;
        $I->seeInDatabase('user', [
            'fullname' => 'Tan Ah Boy',
            'role' => 10,
            'status' => 10,
        ]);
    }    

}
