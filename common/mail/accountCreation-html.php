<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Account Creation</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<style type="text/css">
  
  /* CLIENT-SPECIFIC STYLES ------------------- */
  
  

  /* RESET STYLES --------------------------- */
  
  

  /* MOBILE STYLES ------------------------ */
  
    
</style>
</head>
<body style="margin: 0; padding: 0;">

<!-- CONTAINER TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
  <tr>
    <td align="center" style="padding: 20px 0 20px 0;">
      <!-- WRAPPER TABLE -->
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO/PREHEADER TEXT -->
        <tr>
          <td style="border-bottom: 10px solid #fbbc05; padding: 0 20px 5px 20px">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td align="left" style="font-size: 20px; font-weight: bold;">
                  <?= Html::encode(Yii::$app->name) ?>
                </td>
                <td align="right">
                  <img src="http://i.imgur.com/HOofG19.png" width="50" height="50" />
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- CONTAINER TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
  <tr>
    <td>
      <!-- WRAPPER TABLE -->
      <table border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
          <td style="padding: 0 0 20px 0">
            <table border="0" cellpadding="0" cellspacing="0"  width="100%" style="font-weight: bold; font-size: 20px">
              <tr>
                <td>
                  Dear, <?= Html::encode($user->fullname) ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- CONTAINER TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
  <tr>
    <td>
      <!-- WRAPPER TABLE -->
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td>
          	<p>
            	Congratulates! You have successfully activated your account in Hop On System.
            </p>

            <p>
              To contact Hop On Team, please email us at <?= Yii::$app->params['supportEmail'] ?>.
            </p>

						<p>
							If you are not the intended recipient, please delete this email.
						</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- FOOTER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
  <tr>
    <td>
      <!-- WRAPPER TABLE -->
      <table border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
          <td style="padding: 30px 0 0 0">
            Kind regards,<br />
            Hop On Team<br />
            <img src="http://i.imgur.com/HOofG19.png" width="50" height="50" style="margin-top: 10px" />
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

</body>
</html>
