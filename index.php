<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/config.php';
require_once 'core/Router.php';

$app = new Router();
?>
