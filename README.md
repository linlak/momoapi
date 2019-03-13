# Momo PHP Api Version 1.0 #

This is a php library that has been designed to help developers to easily integrated the momo api into their system.



## Prerequisites ##
This library depends on guzzlehttp to perform http requests.

##Installation##
------------

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
 


**Code Snippet ** 


`
	
<?php

	require_once {path-to-vendor}/vendor/autoload.php;

	use Momo\MomoApp\Products\ApiUser;

	$apiPrimaryKey="***** your primary key for on your profile *****";
	$apiSecondaryKey="***** your secondary key for on your profile *****";



`

