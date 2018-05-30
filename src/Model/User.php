<?php

namespace App\Model;

use App\Model\Model;
use App\Model\BalanceHistory;

class User extends Model {

  public function __construct() {
    parent::__construct('users');
  }

  public function transferMoney($fromUserId = null, $toUserId = null, $amount = null) {
    $fromUserId = (int)$fromUserId;
    $toUserId = (int)$toUserId;
    $amount = (float)$amount;

    if (!$fromUserId || !$toUserId || !$amount) {
      throw new \Exception('Transfer money: wrong input data');
    }

    $balanceHistoryModel = new BalanceHistory();
    $balanceHistoryTableName = $balanceHistoryModel->getTableName();

    $this->_db->autocommit(false);

    $res = $this->_db->query("SELECT * FROM {$this->_table} WHERE id IN ($fromUserId, $toUserId) FOR UPDATE");
    if ($res) {
      $usersRows = $res->fetch_all(MYSQLI_ASSOC);
      if (!$this->_isMoneyTransferValid($usersRows, $fromUserId, $toUserId, $amount)) {
        $this->_db->rollback();
        throw new \Exception('Money transfer not valid');
      }
    }
    $this->_db->query("UPDATE users SET balance = balance - $amount WHERE id = $fromUserId");
    $this->_db->query("UPDATE users SET balance = balance + $amount WHERE id = $toUserId");
    $this->_db->query("INSERT INTO $balanceHistoryTableName (user_id, balance_change, transaction_datetime) VALUES ($fromUserId, $amount * -1, CURRENT_TIMESTAMP), ($toUserId, $amount, CURRENT_TIMESTAMP)");
    $this->_db->commit();

    return true;
  }

  protected function _isMoneyTransferValid($usersRows, $fromUserId, $toUserId, $transferAmount) {
    if ($fromUserId == $toUserId) {
      return false;
    }
    if (sizeof($usersRows) < 2) {
      return false;
    }
    foreach ($usersRows as $user) {
      if ($user['id'] == $fromUserId && $user['balance'] < $transferAmount) {
        return false;
      }
    }

    return true;
  }

}
