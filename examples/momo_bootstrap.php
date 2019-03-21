<?php
	set_time_limit(500);
	require '{path-to-vendor}/vendor/autoload.php';

	use Momo\MomoApp\Bootstraper;
	$momoBootstrap=new Bootstraper('{dbHost}','{dbName}','{dbUser}','{dbPass}','{environment}');