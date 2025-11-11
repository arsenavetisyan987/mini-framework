<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\Core\Database\Connection;
use App\Models\BaseModel;

$connection = new Connection();
BaseModel::setConnection($connection);

echo "Database connection initialized.\n";