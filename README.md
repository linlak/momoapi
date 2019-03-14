# Momo PHP Api Version 1.0 #

This is a php library that has been designed to help developers to easily integrate the **momo api** into their system.



## Prerequisites ##

Before you start using this library we assume that you have good knowledge of php, composer and namespace autoloading. And have installed all the required software to enable run the examples provided here.

You must also have an account on the Momo Developer Portal [https://momodeveloper.mtn.com/](https://momodeveloper.mtn.com/ "Visit page")

**Software**

The following software is require for better results:-

- Testing server with php support e.g xampp,lampp,wampp etc.
- Composer a dependency manager for php. [https://getcomposer.org/](https://getcomposer.org/ "Go to docs")
- Text editor
	- Sublime text
	- NotePad ++
	- Visual code etc.
- A web browser e.g google chrome, mozilla etc.

**Features**

- This library depends on guzzlehttp to perform http requests.


## Installation ##

Use composer to manage your dependencies and download Momo Api Library:


	
	composer require linlak/momoapi
	
## Example ##
**Creating ApiUser** [https://momodeveloper.mtn.com/docs/services/sandbox-provisioning-api](https://momodeveloper.mtn.com/docs/services/sandbox-provisioning-api "Read More")

The following code snippet will help to create an **apiUser** this supports all products these include:

- Collection [https://momodeveloper.mtn.com/docs/services/collection](https://momodeveloper.mtn.com/docs/services/collection "Read More")
- Remittances [https://momodeveloper.mtn.com/docs/services/remittance](https://momodeveloper.mtn.com/docs/services/remittance "Read More")
- Disbursements [https://momodeveloper.mtn.com/docs/services/disbursement](https://momodeveloper.mtn.com/docs/services/disbursement "Read More") 
 
**Note:**



> Whenever we show text in curry brackets ("{text}") please replace that text with the required data without brackets.


***api_user.php***


	
	<?php

		require_once "{path-to-vendor}/vendor/autoload.php";

		use Momo\MomoApp\Products\ApiUser;

		$apiPrimaryKey="{your primary key found on your profile}";

		$apiSecondaryKey="{your secondary key found on your profile}";

		$apiUser=new ApiUser($apiPrimaryKey,$apiSecondaryKey,"sandbox");
	
	


***user_id.php***

    
	<?php 
		require_oce "api_user.php";

		//let's create the UUID you will need to save this id for later use.

		$uid=$apiUser->gen_uuid();

		 echo($uid);


***create_apiuser.php***


	<?php
		require_once "api_user.php";

		$uid="{the uid you created in user_id.php}";
		$providerCallbackHost="{your host here}";

		//array
		$result=$apiUser->createApiUser($uid,$providerCallbackHost);
		
		//let's print the result;

		echo "<pre>";
			print_r($result);

***api_userinfo.php***

	<?php
		require_once "api_user.php";

		$uid="{the uid you created in user_id.php}";

		//array
		$result=$apiUser->getApiUser($uid);
		
		//let's print the result;

		echo "<pre>";
			print_r($result);

***create_apikey.php***
	
	<?php
		require_once "api_user.php";

		$uid="{the uid you created in user_id.php}";
	
		$result=$apiUser->getApikey($uid);

		//let print the result but u will need to save the apiKey somewhere.

		echo "<pre>";
			print_r($result);


If you are successful up to this stage, you have managed to create the **apiUserId** and **apiUserKey**

3/13/2019 9:04:30 AM

## Let's Go to another level ##

We are going to perform the following tasks here:

- fetch token
- request balance
- verify accountHolder

If you have read the Momo developer docs carefully, you noticed that the above requests apply to all the products i.e 

- Collection
- Remittances
- Disbursements

We are going to test with the all packages

Let's create a file name *momo_bootstrap.php* and define initialize all of our product classes;

***momo_bootstrap.php***

	<?php
		require_once "{path-to-vendor}/vendor/autoload.php}";

		//let's include our namespaces
		use Momo\MomoApp\Products\Collection;
		use Momo\MomoApp\Products\Remittances;
		use Momo\MomoApp\Products\Disbursements;

		$collection=new Collection("{collection primaryKey}",{collection secondaryKey},"sandbox");

		$remittances=new Remittances("{remittances primaryKey}",{remittances secondaryKey},"sandbox");

		$disbursements=new Disbursements("{disbursements primaryKey}",{disbursements secondaryKey},"sandbox");

Now we are going to start performing requests. comment out objects for products you haven't subscribed yet in the above code snippet ***momo_bootstrap.php***.

**Note:**
> $uid, $apiKey must be specific for each product.
>  There you have to initialize the $apiUser object in api_user.php using respective primaryKey,secondaryKey combinations and save them somewhere for future reference.


***token.php***

	<?php
		/*
			requesting the token token takes alot of time so is set the time to 500 secends to prevent time exception
		*/
		set_time_limit(500);
		require_once "momo_bootstrap.php";

		$uid="{uid you created in user_id.php}";//create for each product

		$apiKey="{apikey you created in create_apikey.php}"; //create apiKey for each product

		$collection->setApiUserId($uid);
		$collection->setApiKey($apiKey);

		//array
		$result=$collection->requestToken();

		/*to request tokens for other products, use the 
		* pruduct's object defined in momo_bootstrap.php
		* e.g
		*/
		//$remittances->setApiUserId($uid);
		//$remittances->setApiKey($apiKey);
		//$result=$remittances->requestToken(); 
		//or
		//$disbursements->setApiUserId($uid);
		//$disbursements->setApiKey($apiKey);
		//$result=$disbursements->requestToken();

		//let's print the result but you will need to save the token and expiry time somewhere for reference;

		echo "<pre>";
		print_r($result);
		
		
Now we have the token for our product's ***apiUser*** let's request balance

***balance.php***

	<?php
		require_once "momo_bootstrap.php";

		$uid="{uid you created in user_id.php}";//create for each product

		$apiKey="{apikey you created in create_apikey.php}"; //create apiKey for each product
		
		$token="{token you created in token.php}";//create for each product you subscribed

		$collection->setApiUserId($uid);
		$collection->setApiKey($apiKey);
		$collection->setApiToken($token);

		//array
		$result=$collection->requestBalance();

		/*to request balance for other products, use the 
		* pruduct's object defined in momo_bootstrap.php
		* e.g
		*/
		//$remittances->setApiUserId($uid);
		//$remittances->setApiKey($apiKey);
		//$remittances->setApiToken($token);
		//$result=$remittances->requestBalance(); 
		//or
		//$disbursements->setApiUserId($uid);
		//$disbursements->setApiKey($apiKey);
		//$disbursements->setApiToken($token);
		//$result=$disbursements->requestBalance();

		//let's print the result

		echo "<pre>";
		print_r($result);

Let's verify account holder

***account_holder.php***

	<?php
		require_once "momo_bootstrap.php";

		$uid="{uid you created in user_id.php}";//create for each product

		$apiKey="{apikey you created in create_apikey.php}"; //create apiKey for each product
		
		$token="{token you created in token.php}";//create for each product you subscribed

		$acoutHolderId="{acoutHolderId}";
		$acoutHolderIdType="{acoutHolderIdType}";

		$collection->setApiUserId($uid);
		$collection->setApiKey($apiKey);
		$collection->setApiToken($token);

		//array
		$result=$collection->acountHolder($accountHolderIdType,$accountHolderId);

		/*to request balance for other products, use the 
		* pruduct's object defined in momo_bootstrap.php
		* e.g
		*/
		//$remittances->setApiUserId($uid);
		//$remittances->setApiKey($apiKey);
		//$remittances->setApiToken($token);
		//$result=$remittances->acountHolder($accountHolderIdType,$accountHolderId); 
		//or
		//$disbursements->setApiUserId($uid);
		//$disbursements->setApiKey($apiKey);
		//$disbursements->setApiToken($token);
		//$result=$disbursements->acountHolder($accountHolderIdType,$accountHolderId);

		//let's print the result

		echo "<pre>";
		print_r($result);

We are now going to perform a requestToPay and requestToPayStatus.

**Note:** These apply to Collection product only.

***request_topay.php***

	<?php
		require_once "momo_bootstrap.php";
		use Momo\MomoApp\Models\RequestToPay;
		$uid="{uid you created in user_id.php}";//for Collection product

		$apiKey="{apikey you created in create_apikey.php}"; //apiKey for Collection product
		
		$token="{token you created in token.php}";//token for Collection product

		$collection->setApiUserId($uid);
		$collection->setApiKey($apiKey);
		$collection->setApiToken($token);
		
		//requestToPay object

		$requestToPay=new RequestToPay("{externalId}","{amount}","{partyId}","{partyIdType}","{payeeNote}","{payerMessage}");

		//to set the currency

		$requestToPay->setCurrency("{curency}");// read docs for more info on supported currencies.

		$callbackUrl="{url to your webhook}";

		$ref=$collection->gen_uuid(); //you should save this for future reference

		//array
		$result=$collection->requestToPay($requestToPay,$ref,$callbackUrl);
		//let's print the result

		echo "<pre>";
		print_r($result);



***request_status.php***

	<?php
		require_once "momo_bootstrap.php";

		$uid="{uid you created in user_id.php}";//for Collection product

		$apiKey="{apikey you created in create_apikey.php}"; //apiKey for Collection product
		
		$token="{token you created in token.php}";//token for Collection product

		$collection->setApiUserId($uid);
		$collection->setApiKey($apiKey);
		$collection->setApiToken($token);
		

		$ref="{ref you created in request_topay.php}";

		//array
		$result=$collection->requestToPayStatus($ref);
		//let's print the result

		echo "<pre>";
		print_r($result);


We are now going to perform a transfer and tranferStatus.

**Note:** These apply to Remittances and Disbursements products only.

***transfer.php***

	<?php
		require_once "momo_bootstrap.php";
		use Momo\MomoApp\Models\RequestToPay;
		$uid="{uid you created in user_id.php}";//for each product

		$apiKey="{apikey you created in create_apikey.php}"; //create apiKey for each product
		
		$token="{token you created in token.php}";//create token for each product

		//for Disbursements replace $remittances with $disbursements

		$remittances->setApiUserId($uid);
		$remittances->setApiKey($apiKey);
		$remittances->setApiToken($token);
		
		//requestToPay object

		$requestToPay=new RequestToPay("{externalId}","{amount}","{partyId}","{partyIdType}","{payeeNote}","{payerMessage}");

		//to set the currency

		$requestToPay->setCurrency("{curency}");// read docs for more info on supported currencies.

		$callbackUrl="{url to your webhook}";

		$ref=$remittances->gen_uuid(); //you should save this for future reference

		//array

		$result=$remittances->transfer($requestToPay,$ref,$callbackUrl);

		//let's print the result

		echo "<pre>";
		print_r($result);


***transfer_status.php***

	<?php
		require_once "momo_bootstrap.php";

		$uid="{uid you created in user_id.php}";//for each product

		$apiKey="{apikey you created in create_apikey.php}"; //create apiKey for each product
		
		$token="{token you created in token.php}";//create token for each product

		//for Disbursements replace $remittances with $disbursements

		$remittances->setApiUserId($uid);
		$remittances->setApiKey($apiKey);
		$remittances->setApiToken($token);
		
		$ref="{ref you created in transer.php}";

		//array

		$result=$remittances->transferStatus($ref);

		//let's print the result

		echo "<pre>";
		print_r($result);



## To be fixed ##

This library can only create the api user please don't hesitate to inform me when you find a fix/solution. 
[mailto:ugsalons@gmail.com](mailto:ugsalons@gmail.com "Send Email")
