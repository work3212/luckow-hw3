<?php

error_reporting(E_ALL);


set_time_limit(0);

ob_implicit_flush();

$socketDomain = 'tcp://test.xx:8000';
$connectionTimeSeconds = 60;
$limitMessages = 60;