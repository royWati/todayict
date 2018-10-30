<?php
session_start();
$_SESSION['user']['userid'] = $_GET['userid'];
$_SESSION['user']['log'] = "log";