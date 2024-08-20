<?php
require('../connect.php');
$token = $_POST["stripeToken"];
$token_card_type = $_POST["stripeTokenType"];
$charge =\Stripe\Charge::create(array(
	'amount' => str_replace(",", "", $renting_price) * 100,
	'currency' => 'usd',
	'source' => $token,
));
// if($charge){
// 	header("Location:receipt.php?amount=$renting_price")
// }
?>