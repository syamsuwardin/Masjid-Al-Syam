<?php
session_start();
require_once '../app/config/config.php';
require_once '../app/config/database.php';
require_once '../app/core/App.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';

$app = new App();