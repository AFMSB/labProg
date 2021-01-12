<?php

session_start();

require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51I5sGvG6ZrDa2rDvDd7sgaZEMe5VHEAfThyFXRN6RcIPfYzXxCasPPnDTm5ze5Srx1nkgNfbBGOcftQB61Wgwfzk00GOQUlIxx');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://homestead.test/projetolab';

$valor = $_SESSION['total'] * 100;

$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price_data' => [
      'currency' => 'eur',
      'unit_amount' => $valor,
      'product_data' => [
        'name' => 'Stubborn Attachments',
        'images' => ["https://static.fnac-static.com/multimedia/Images/PT/NR/82/e0/54/5562498/1540-1.jpg"],
      ],
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/paymentsucess.php',
  'cancel_url' => $YOUR_DOMAIN . '/checkout.php',
]);

echo json_encode(['id' => $checkout_session->id]);