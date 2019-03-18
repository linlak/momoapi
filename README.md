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

Let's start by bootstrapping our momo library in the code snippet bellow.

**Note: ** The apiUser is generated automatically

***momo_bootstrap.php***

	<?php
		set_time_limit(500);
		require '{path-to-vendor}/vendor/autoload.php';

		use Momo\MomoApp\Bootstraper;
		$momoBootstrap=new Bootstraper('{dbHost}','{dbName}','{dbUser}','{dbPass}',{environment});
		  
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

		$ref=$collection->gen_uuid(); //you should save this for future reference

		//array
		$result=$collection->requestToPay($requestToPay,$ref,$callbackUrl);
		//let's print the result

		echo "<pre>";
		print_r($result);



***request_status.php***

	<?php
		require_once "momo_collections.php";

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
		require_once "momo_remittances.php";
		use Momo\MomoApp\Models\RequestToPay;
		

		//for Disbursements replace $remittances with $disbursements
		
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
		require_once "momo_remittances.php";

		//for Disbursements replace remittances with disbursements
		
		$ref="{ref you created in transer.php}";

		//array

		$result=$remittances->transferStatus($ref);

		//let's print the result

		echo "<pre>";
		print_r($result);


If you are successful up to this step, Congratulations you have managed to integrate the momoapi into your system. Though there is still more yet to come keep checking in for updates and I strongly recommend you to use **Composer** for your php dependency management,it will help you to easily update libraries in a single command.
	
	composer update

With the above command you will have all your dependencies updated. 


## Up Next ##

Setting **Webhooks** these will help you to write code for the callbackUrl. For info contact me at the email provided bellow.

Check in for updates.

**Nice coding**

Regards

Linus Nowomukama

[mailto:ugsalons@gmail.com](mailto:ugsalons@gmail.com "Send Email")

[tel:+256783198167](tel:+256783198167 "Call me")




