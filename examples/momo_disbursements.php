<?php
	require_once "momo_bootstrap.php}";
	$callBackUrl="{callbackurl}";
	$disbursements=$momoBootstrap->initDisbursements("{disbursements primaryKey}","{disbursements secondaryKey}",$callBackUrl);