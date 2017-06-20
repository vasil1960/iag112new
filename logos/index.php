<?php
session_start();

include('../Session.php');

$session = Session::accessLogos($_POST['password']);

$session ? include('content.php') : include('login.php');