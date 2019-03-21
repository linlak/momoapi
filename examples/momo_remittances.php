<?php
	require_once "momo_bootstrap.php}";
	$callBackUrl="{callbackurl}";
	$remittances=$momoBootstrap->initRemittances("{remittances primaryKey}","{remittances secondaryKey}",$callBackUrl);