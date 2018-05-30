<?php

namespace App\Model;

class Model {
  protected $_table;
  protected $_db;

  public function __construct($table) {
    $this->_table = $table;
    $this->_dbConnect(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);
  }

  protected function _dbConnect($host, $dbName, $user, $pass) {
    $this->_db = new \mysqli($host, $user, $pass, $dbName);
    if ($this->_db->connect_errno) {
      throw new \Exception('DB connection error: ' . $this->_db->connect_errno);
      exit();
    }
  }

  public function getTableName() {
    return $this->_table;
  }

  // basic CRUD methods
}
