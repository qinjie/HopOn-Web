<?php
namespace tests\codeception\api;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

   /**
    * Define custom actions here
    */

  public function login($username, $password) {
   	$I = $this;
   	$I->sendPOST('user/login', [
	  	'username' => '1111',
	  	'password' => '123456'
    ]);
    $I->seeResponseCodeIs(200);
    $I->seeResponseMatchesJsonType([
      'user_id' => 'integer',
      'auth_key' => 'string',
      'token' => 'string',
      'fullname' => 'string'
    ]);
    return json_decode($I->grabResponse());
  }

}
