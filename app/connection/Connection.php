<?php

namespace app\connection;

use app\adapter\IMain;

class Connection
{
    private $connection;

    public function __construct(IMain $connection) {
        $this->connection = $connection;
    }

    public function getConnection() {
        return $this->connection;
    }
}