# Momo PHP Api Version 1.0 #

This is a php library that has been designed to help developers to easily integrate the **momo api** into their system.

## Solution ##
After finding out that most developers were having trouble integrating the momoapi into there system. We came up with this simple php library to make the integration easy and fast.

## Prerequisites ##

Before you start using this library we assume that you have good knowledge of php, composer and namespace autoloading. And have installed all the required software to enable run the examples provided here.

You must also have an account on the Momo Developer Portal [https://momodeveloper.mtn.com/](https://momodeveloper.mtn.com/ "Visit page")

**Software**

The following software is require for better results:-

- Testing server with **PHP** and **MYSQL** support e.g xampp,lampp,wampp etc.
- Composer a dependency manager for php. [https://getcomposer.org/](https://getcomposer.org/ "Go to docs")
- Text editor
	- Sublime text
	- NotePad ++
	- Visual code etc.
- A web browser e.g google chrome, mozilla etc.

**Features**

- This library depends on guzzlehttp to perform http requests.
- ApiUsers, accessTokens, apiKeys are stored in the database and all of this is done the first time a product is initailized.
- AccessTokens are refreshed once they approach expiration. We have all of this for you. 


## Installation ##

Use composer to manage your dependencies and download Momo Api Library:


	
	composer require linlak/momoapi
	
## Examples ##
**Creating ApiUser** [https://momodeveloper.mtn.com/docs/services/sandbox-provisioning-api](https://momodeveloper.mtn.com/docs/services/sandbox-provisioning-api "Read More")

The following code snippet will help to create an **apiUser** this supports all products these include:

- Collection [https://momodeveloper.mtn.com/docs/services/collection](https://momodeveloper.mtn.com/docs/services/collection "Read More")
- Remittances [https://momodeveloper.mtn.com/docs/services/remittance](https://momodeveloper.mtn.com/docs/services/remittance "Read More")
- Disbursements [https://momodeveloper.mtn.com/docs/services/disbursement](https://momodeveloper.mtn.com/docs/services/disbursement "Read More") 
 
**Note:**



> Whenever we show text in curry brackets ("{text}") please replace that text with the required data without brackets.

Let's start by bootstrapping our momo library in the code snippet bellow.

**Note: ** The apiUser is generated automatically


***momo_bootstrap.php***

	<?php
		set_time_limit(500);
		require '{path-to-vendor}/vendor/autoload.php';

		use Momo\MomoApp\Bootstraper;
		$momoBootstrap=new Bootstraper('{dbHost}','{dbName}','{dbUser}','{dbPass}','{environment}');
		  
We are going to perform the following tasks here:

- request balance
- verify accountHolder


***momo_collections.php***

	<?php
		require_once "momo_bootstrap.php}";

		$callBackUrl="{callbackurl}";
		$collection=$momoBootstrap->initCollection("{collection primaryKey}",{collection secondaryKey},$callbackUrl);



***momo_remittances.php***

	<?php
		require_once "momo_bootstrap.php}";
		$callBackUrl="{callbackurl}";
		$remittances=$momoBootstrap->initRemittances("{remittances primaryKey}",{remittances secondaryKey},$callBackUrl);



***momo_disbursements.php***

	<?php
		require_once "momo_bootstrap.php}";
		$callBackUrl="{callbackurl}";
		$disbursements=$momoBootstrap->initDisbursements("{disbursements primaryKey}",{disbursements secondaryKey},$callBackUrl);



***collection_balance.php***

	<?php
		require_once "momo_collections.php";

		//instanceof BalanceResponse
		$result=$collection->requestBalance();

		//let's print the result

		if($result->isFound()){
			$availableBalance=$result->getAvailableBalance();
			$currency=$result->getCurrency();
			echo('availableBalance: '.$availableBalance.'\n\r');
			echo('currency: '.$currency.'\n\r');
		}




***remittances_balance.php***

	<?php
		require_once "momo_remittances.php";

		//instanceof BalanceResponse
		$result=$remittances->requestBalance();

		//let's print the result

		if($result->isFound()){
			$availableBalance=$result->getAvailableBalance();
			$currency=$result->getCurrency();
			echo('availableBalance: '.$availableBalance.'\n\r');
			echo('currency: '.$currency.'\n\r');
		}


***disbursements_balance.php***

	<?php
		require_once "momo_disbursements.php";

		//instanceof BalanceResponse
		$result=$disbursements->requestBalance();

		//let's print the result

		if($result->isFound()){
			$availableBalance=$result->getAvailableBalance();
			$currency=$result->getCurrency();
			echo('availableBalance: '.$availableBalance.'\n\r');
			echo('currency: '.$currency.'\n\r');
		}




Let's verify account holder



***collections_accountholder.php***

	<?php
		require_once "momo_collections.php";

		$acoutHolderId="{acoutHolderId}";
		$acoutHolderIdType="{acoutHolderIdType}";

		//array
		$result=$collection->acountHolder($accountHolderIdType,$accountHolderId);

		//let's print the result

		echo "<pre>";
		print_r($result);




***remittances_accountholder.php***

	<?php
		require_once "momo_remittances.php";


		$acoutHolderId="{acoutHolderId}";
		$acoutHolderIdType="{acoutHolderIdType}";

		//array
		$result=$remittances->acountHolder($accountHolderIdType,$accountHolderId);

		//let's print the result

		echo "<pre>";
		print_r($result);



***disbursements_accountholder.php***

	<?php
		require_once "momo_disbursements.php";


		$acoutHolderId="{acoutHolderId}";
		$acoutHolderIdType="{acoutHolderIdType}";

		//array
		$result=$disbursements->acountHolder($accountHolderIdType,$accountHolderId);

		//let's print the result

		echo "<pre>";
		print_r($result);



We are now going to perform a requestToPay and requestToPayStatus.

**Note:** These apply to Collection product only.

***request_topay.php***

	<?php
		require_once "momo_collections.php";
		use Momo\MomoApp\Models\RequestToPay;
				
		//requestToPay object

		$requestToPay=new RequestToPay("{externalId}","{amount}","{partyId}","{partyIdType}","{payeeNote}","{payerMessage}");

		//to set the currency

		$requestToPay->setCurrency("{curency}");// read docs for more info on supported currencies.

		$callbackUrl="{url to your webhook}";

		//array
		$result=$collection->requestToPay($requestToPay,$callbackUrl);
		//let's print the result

		echo "<pre>";
		print_r($result);



***request_status.php***

	<?php
		require_once "momo_collections.php";

		$referenceId="{referenceId  returned in request_topay.php}";

		//array
		$result=$collection->requestToPayStatus($referenceId);
		//let's print the result

		echo "<pre>";
		print_r($result);


We are now going to perform a transfer and tranferStatus.

**Note:** These apply to Remittances and Disbursements products only.

***transfer.php***

	<?php
		require_once "momo_remittances.php";
		use Momo\MomoApp\Models\RequestToPay;
		

		//for Disbursements replace $remittances with $disbursements
		
		//requestToPay object

		$requestToPay=new RequestToPay("{externalId}","{amount}","{partyId}","{partyIdType}","{payeeNote}","{payerMessage}");

		//to set the currency

		$requestToPay->setCurrency("{curency}");// read docs for more info on supported currencies.

		$callbackUrl="{url to your webhook}";
		
		//array

		$result=$remittances->transfer($requestToPay,$callbackUrl);

		//let's print the result

		echo "<pre>";
		print_r($result);


***transfer_status.php***

	<?php
		require_once "momo_remittances.php";

		//for Disbursements replace remittances with disbursements
		
		$referenceId="{referenceId  returned in transer.php}";

		//array

		$result=$remittances->transferStatus($referenceId);

		//let's print the result

		echo "<pre>";
		print_r($result);



**sample result for the following files**

- request_topay.php
- request_status.php
- transfer.php
- transfer_status.php

![](https://github.com/linlak/momoapi/blob/master/images/reqstatus.png)

The image above show the result for the files listed above.
You are required to compare the results with your payments table to confirm if the request was created,successful,timed out or rejected.

For **request_topay.php** status is **PENDING** for the rest it can be either PENDING, SUCCESSFUL, FAILED. If status is **FAILED** you should check the **reason** to see if it was rejected or timed out.

Note: If the result is not as in the image shown above then request was not successful, or resource was not found in these cases the result is false therefore it is better you wrap it in an **IF** statement.****

> As you all know that
> Programming is an Art. You can now manipulate the result to meet your desired outcome.

If you are successful up to this step, Congratulations you have managed to integrate the momo api into your system. Though there is still more yet to come keep checking in for updates and I strongly recommend you to use **Composer** for your php dependency management,it will help you to easily update libraries in a single command.
	
	composer update

With the above command you will have all your dependencies updated. 


## Up Next ##

Setting **Webhooks** these will help you to write code for the callbackUrl. For more info contact me at the email provided bellow.

Check in for updates.

## Acknowledgements ##

Every good work is always appreciated and for this reason I should acknowledge appreciations from some of the users who found this tool valuable.

**1. APPSCORE INSTITUTE OF DIGITAL TECHNOLOGY** - I thank APPSCORE for the Certificate

**Nice coding**

Regards

Linus Nowomukama

[mailto:ugsalons@gmail.com](mailto:ugsalons@gmail.com "Send Email")

[tel:+256783198167](tel:+256783198167 "Call me")

[tel:+256751921465](tel:+256751921465 "Call or Watsapp")