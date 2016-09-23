<?php
namespace tests\codeception\api;
use tests\codeception\api\FunctionalTester;

class SignupCest
{
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
    }


}
