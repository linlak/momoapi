# Momo PHP Api Version 1.0 #

This is a php library that has been designed to help developers to easily integrated the momo api into their system.



## Prerequisites ##
This library depends on guzzlehttp to perform http requests.

##Installation##

Use composer to manage your dependencies and download Momo Api Library:

```bash
composer require linlak/momoapi
```
## Example ##
**Creating ApiUser** [https://momodeveloper.mtn.com/docs/services/sandbox-provisioning-api](https://momodeveloper.mtn.com/docs/services/sandbox-provisioning-api "Read More")

The following code snippet will help to create an **apiUser** this supports all products these include:

- Collection [https://momodeveloper.mtn.com/docs/services/collection](https://momodeveloper.mtn.com/docs/services/collection "Read More")
- Remittances [https://momodeveloper.mtn.com/docs/services/remittance](https://momodeveloper.mtn.com/docs/services/remittance "Read More")
- Disbursements [https://momodeveloper.mtn.com/docs/services/disbursement](https://momodeveloper.mtn.com/docs/services/disbursement "Read More") 
 



***api_user.php***


	
	<?php

	require_once {path-to-vendor}/vendor/autoload.php;

	use Momo\MomoApp\Products\ApiUser;

	$apiPrimaryKey="{your primary key for on your profile}";

	$apiSecondaryKey="{your secondary key for on your profile}";

	$apiUser=new ApiUser($apiPrimaryKey,$apiSecondaryKey);
	
	


***user_id.php***

    
	<?php 
		require_oce "api_user.php";

		//let's create the UUID you willneed to save this id for letter user

		$uid=$apiUser->gen_uuid();

		 echo($uid);


***create_apiuser.php***


	<?php
		require_once "api_user.php";

		$uid="{the uid created in user_id.php}";
		$providerCallbackHost="{you host here}";

		//array
		$result=$apiUser->createApiUser($uid,$providerCallbackHost);
		
		//let's print the result;

		echo "<pre>;
			print_r($result);

***api_userinfo.php***

	<?php
		require_once "api_user.php";

		$uid="{the uid created in user_id.php}";

		//array
		$result=$apiUser->getApiUser($uid);
		
		//let's print the result;

		echo "<pre>;
			print_r($result);

***create_apikey.php***
	
	<?php
		require_once "api_user.php";

		$uid="{the uid created in user_id.php}";
	
		$result=$apiUser->getApikey($uid);

		//let print the result but u will need to save the apiKey somewhere.

		echo "<pre>;
			print_r($result);


If you are successful up to this stage, you have managed to create the **apiUserId** and **apiUserKey**

## To be fixed ##

This library can only create the api user please don't hesitate to inform me when you find a fix/solution. 