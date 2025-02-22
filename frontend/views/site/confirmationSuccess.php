<?php

use yii\helpers\Html;

?>

<!DOCTYPE html>
<html>
<head>
	<title><?= Html::encode(Yii::$app->name) ?></title>
	<style type="text/css">
		body {
			margin: 0;
			padding: 0;
			font-family: "Trebuchet MS", Helvetica, sans-serif;
		}
		header {
			width: 100%;
			font-size: 30px;
			padding: 20px;
			color: #00BCD4;
		}

		.main-content {
			width: 60%;
			margin: auto;
			background-color: white;
			padding: 30px;
			border: 20px solid #00BFFF;
			-webkit-box-shadow: 0 8px 6px -6px black;
	   	-moz-box-shadow: 0 8px 6px -6px black;
	    box-shadow: 0 8px 6px -6px black;
		}

		.title {
			font-size: 20px;
		}

		.desc {
			margin-top: 10px;
			font-size: 15px;
		}
	</style>
</head>
<body>
	<header>
		Confirmation Success
	</header>
	<div class="main-content">
		<div class="title">Thank you</div>
		<div class="desc">
			Your account has been activated! You may now login.
		</div>
	</div>
</body>
</html>