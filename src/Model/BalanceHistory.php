<?php

namespace App\Model;
use App\Model\Model;

class BalanceHistory extends Model {

  public function __construct() {
    parent::__construct('balance_histories');
  }

}
