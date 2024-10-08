<?php
include("../password.php");

$token = $_POST["stripeToken"];
$contact_name = $_POST["c_name"];
$token_card_type = $_POST["stripeTokenType"];
$phone = $_POST["phone"];
$email = $_POST["stripeEmail"];
$address = $_POST["address"];
$amount = str_replace(",", "", $_POST["amount"]);
$desc = $_POST["product_name"];

$charge = \Stripe\Charge::create([
    "amount" => intval($amount * 100),
    "currency" => 'usd',
    "description" => $desc,
    "source" => $token,
]);

if ($charge) {
    header("Location:success.php?amount=$amount");
}
?>
