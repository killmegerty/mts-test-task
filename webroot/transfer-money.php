<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'bootstrap.php';

use App\Model\User;

try {
  // $_GET instead $_POST for testing in browser
  $fromUserId = isset($_GET['fromUserId']) ? $_GET['fromUserId'] : null;
  $toUserId = isset($_GET['toUserId']) ? $_GET['toUserId'] : null;
  $amount = isset($_GET['amount']) ? $_GET['amount'] : null;

  $userModel = new User();
  $res = $userModel->transferMoney($fromUserId, $toUserId, $amount);
  if ($res) {
    echo json_encode([
      'msg' => 'Money transferred',
      'code' => 200
    ]);
  }
} catch (\Exception $e) {
  echo json_encode([
    'error_msg' => $e->getMessage(),
    'code' => 500
  ]);
  exit;
}
