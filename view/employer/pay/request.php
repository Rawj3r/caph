<?php
	/*
	 * Once the client is ready to be redirected to the payment page, we get all the information needed and initiate the transaction with PayGate.
	 * This checks that all the information is valid and that a transaction can take place.
	 * If the initiate is successful we are returned a request ID and a checksum which we will use to redirect the client to PayWeb3.
	 */

	/*
	 * Sessions used here only because we can't get the PayGate ID, Transaction reference and secret key on the result page.
	 */
	session_name('paygate_payweb3_testing_sample');
	session_start();

	include_once('../lib/php/global.inc.php');

	/*
	 * Include the helper PayWeb 3 class
	 */
	require_once('paygate.payweb3.php');

	$mandatoryFields = array(
		'PAYGATE_ID'        => filter_var($_POST['PAYGATE_ID'], FILTER_SANITIZE_STRING),
		'REFERENCE'         => filter_var($_POST['REFERENCE'], FILTER_SANITIZE_STRING),
		'AMOUNT'            => filter_var($_POST['AMOUNT']*100, FILTER_SANITIZE_NUMBER_INT),
		'CURRENCY'          => filter_var($_POST['CURRENCY'], FILTER_SANITIZE_STRING),
		'RETURN_URL'        => filter_var($_POST['RETURN_URL'], FILTER_SANITIZE_URL),
		'TRANSACTION_DATE'  => filter_var($_POST['TRANSACTION_DATE'], FILTER_SANITIZE_STRING),
		'LOCALE'            => filter_var($_POST['LOCALE'], FILTER_SANITIZE_STRING),
		'COUNTRY'           => filter_var($_POST['COUNTRY'], FILTER_SANITIZE_STRING),
		'EMAIL'             => filter_var($_POST['EMAIL'], FILTER_SANITIZE_EMAIL)
	);

	$optionalFields = array(
		'PAY_METHOD'        => (isset($_POST['PAY_METHOD']) ? filter_var($_POST['PAY_METHOD'], FILTER_SANITIZE_STRING) : ''),
		'PAY_METHOD_DETAIL' => (isset($_POST['PAY_METHOD_DETAIL']) ? filter_var($_POST['PAY_METHOD_DETAIL'], FILTER_SANITIZE_STRING) : ''),
		'NOTIFY_URL'        => (isset($_POST['NOTIFY_URL']) ? filter_var($_POST['NOTIFY_URL'], FILTER_SANITIZE_URL) : ''),
		'USER1'             => (isset($_POST['USER1']) ? filter_var($_POST['USER1'], FILTER_SANITIZE_URL) : ''),
		'USER2'             => (isset($_POST['USER2']) ? filter_var($_POST['USER2'], FILTER_SANITIZE_URL) : ''),
		'USER3'             => (isset($_POST['USER3']) ? filter_var($_POST['USER3'], FILTER_SANITIZE_URL) : ''),
		'VAULT'             => (isset($_POST['VAULT']) ? filter_var($_POST['VAULT'], FILTER_SANITIZE_NUMBER_INT) : ''),
		'VAULT_ID'          => (isset($_POST['VAULT_ID']) ? filter_var($_POST['VAULT_ID'], FILTER_SANITIZE_STRING) : '')
	);

	$data = array_merge($mandatoryFields, $optionalFields);

	$encryption_key  = $_POST['encryption_key'];

	/*
	 * Set the session vars once we have cleaned the inputs
	 */
	$_SESSION['pgid']      = $data['PAYGATE_ID'];
	$_SESSION['reference'] = $data['REFERENCE'];
	$_SESSION['key']       = $encryption_key;

	/*
	 * Initiate the PayWeb 3 helper class
	 */
	$PayWeb3 = new PayGate_PayWeb3();
	/*
	 * if debug is set to true, the curl request and result as well as the calculated checksum source will be logged to the php error log
	 */
	//$PayWeb3->setDebug(true);
	/*
	 * Set the encryption key of your PayGate PayWeb3 configuration
	 */
	$PayWeb3->setEncryptionKey($encryption_key);
	/*
	 * Set the array of fields to be posted to PayGate
	 */
	$PayWeb3->setInitiateRequest($data);

	/*
	 * Do the curl post to PayGate
	 */
	$returnData = $PayWeb3->doInitiate();

?>

<!DOCTYPE html>
<html>
<head>
	
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>PayWeb 3 - Initiate</title>
        <link rel="stylesheet" href="../lib/css/bootstrap.min.css">
        <link rel="stylesheet" href="../lib/css/core.css">
</head>
<body>
<div class="main-container">
    	<div class="grid-container">
        	<div class="grid-x grid-padding-x">

        		<div class="container">
				<form role="form" class="form-horizontal text-left" action="<?php echo $PayWeb3::$process_url ?>" method="post" name="paygate_process_form">
					<div style="display: none;" class="form-group">
						<label style="display: none; for="PAYGATE_ID" class="col-sm-3 control-label">PayGate ID</label>
						<p id="PAYGATE_ID" class="form-control-static"><?php echo $data['PAYGATE_ID']; ?></p>
					</div>
					<div class="form-group">
						<label for="REFERENCE" class="col-sm-3 control-label">Reference</label>
						<p id="REFERENCE" class="form-control-static"><?php echo $data['REFERENCE']; ?></p>
					</div>
					<div class="form-group">
						<label for="AMOUNT" class="col-sm-3 control-label">Amount</label>
						<p id="AMOUNT" class="form-control-static"><?php echo $data['AMOUNT']/100; ?></p>
					</div>
					<div class="form-group">
						<label for="CURRENCY" class="col-sm-3 control-label">Currency</label>
						<p id="CURRENCY" class="form-control-static"><?php echo $data['CURRENCY']; ?></p>
					</div>
					<div style="display: none;" class="form-group">
						<label for="RETURN_URL" class="col-sm-3 control-label">Return URL</label>
						<p id="RETURN_URL" class="form-control-static"><?php echo $data['RETURN_URL']; ?></p>
					</div>
					<div class="form-group" style="display: none;>
						<label for="LOCALE" class="col-sm-3 control-label">Locale</label>
						<p id="LOCALE" class="form-control-static"><?php echo $data['LOCALE']; ?></p>
					</div>
					<div class="form-group">
						<label for="COUNTRY" class="col-sm-3 control-label">Country</label>
						<p id="COUNTRY" class="form-control-static"><?php echo $data['COUNTRY']; ?></p>
					</div>
					<div class="form-group">
						<label for="TRANSACTION_DATE" class="col-sm-3 control-label">Transaction Date</label>
						<p id="TRANSACTION_DATE" class="form-control-static"><?php echo $data['TRANSACTION_DATE']; ?></p>
					</div>
					<div class="form-group">
						<label for="EMAIL" class="col-sm-3 control-label">Customer Email</label>
						<p id="EMAIL" class="form-control-static"><?php echo $data['EMAIL']; ?></p>
					</div>
						<?php
							$displayOptionalFields = false;

							foreach(array_keys($optionalFields) as $key => $value){
								if($data[$value] != ''){
									$displayOptionalFields = true;
								}
							}

							if($displayOptionalFields){
								echo <<<HTML
					<div class="well">
HTML;


								if($data['PAY_METHOD'] != ''){
									echo <<<HTML
					<div class="form-group">
						<label for="PAY_METHOD" class="col-sm-3 control-label">Pay Method</label>
						<p id="PAY_METHOD" class="form-control-static">{$data['PAY_METHOD']}</p>
					</div>
HTML;
								}

								if($data['PAY_METHOD_DETAIL'] != ''){
									echo <<<HTML
					<div class="form-group">
						<label for="PAY_METHOD_DETAIL" class="col-sm-3 control-label">Pay Method Detail</label>
						<p id="PAY_METHOD_DETAIL" class="form-control-static">{$data['PAY_METHOD_DETAIL']}</p>
					</div>
HTML;
								}

								if($data['NOTIFY_URL'] != ''){
									echo <<<HTML
					<div class="form-group">
						<label for="NOTIFY_URL" class="col-sm-3 control-label">Notify Url</label>
						<p id="NOTIFY_URL" class="form-control-static">{$data['NOTIFY_URL']}</p>
					</div>
HTML;
								}

								if($data['USER1'] != ''){
									echo <<<HTML
					<div class="form-group">
						<label for="USER1" class="col-sm-3 control-label">User Field 1</label>
						<p id="USER1" class="form-control-static">{$data['USER1']}</p>
					</div>
HTML;
								}

								if($data['USER2'] != ''){
									echo <<<HTML
					<div class="form-group">
						<label for="USER2" class="col-sm-3 control-label">User Field 2</label>
						<p id="USER2" class="form-control-static">{$data['USER2']}</p>
					</div>
HTML;
								}

								if($data['USER3'] != ''){
									echo <<<HTML
					<div class="form-group">
						<label for="USER3" class="col-sm-3 control-label">User Field 3</label>
						<p id="USER3" class="form-control-static">{$data['USER3']}</p>
					</div>
HTML;
								}

								if($data['VAULT'] != ''){
									echo <<<HTML
					<div class="form-group">
						<label for="VAULT" class="col-sm-3 control-label">Vault</label>
						<p id="VAULT" class="form-control-static">{$data['VAULT']}</p>
					</div>
HTML;
								}

								if($data['VAULT_ID'] != ''){
									echo <<<HTML
					<div class="form-group">
						<label for="VAULT_ID" class="col-sm-3 control-label">Vault ID</label>
						<p id="VAULT_ID" class="form-control-static">{$data['VAULT_ID']}</p>
					</div>
HTML;
								}

								echo <<<HTML
					</div>
HTML;
							} ?>
					<div style="display: none; class="form-group">
						<label for="encryption_key" class="col-sm-3 control-label">Encryption Key</label>
						<p id="encryption_key" class="form-control-static"><?php echo $encryption_key; ?></p>
					</div>
					<?php if(isset($PayWeb3->processRequest) || isset($PayWeb3->lastError)){
						/*
						 * We have received a response from PayWeb3
						 */

						/*
						 * TextArea for display example purposes only.
						 */
						?>
					<div style="display: none; class="form-group">
						<label for="request">Request Result</label><br>
						<textarea class="form-control" rows="3" cols="50" id="request"><?php
							if (!isset($PayWeb3->lastError)) {
								foreach($PayWeb3->processRequest as $key => $value){
									echo <<<HTML
{$key} = {$value}

HTML;
								}
							} else {
								/*
								 * handle the error response
								 */
								echo $PayWeb3->lastError;
							} ?>
						</textarea>
					</div>
					<?php
						if (!isset($PayWeb3->lastError)) {
							/*
							 * It is not an error, so continue
							 */

							/*
							 * Check that the checksum returned matches the checksum we generate
							 */
							$isValid = $PayWeb3->validateChecksum($PayWeb3->initiateResponse);

							if($isValid){
								/*
								 * If the checksums match loop through the returned fields and create the redirect from
								 */
								foreach($PayWeb3->processRequest as $key => $value){
									echo <<<HTML
					<input type="hidden" name="{$key}" value="{$value}" />
HTML;
								}
							} else {
								echo 'Checksums do not match';
							}
						}
						/*
						 * Submit form as/when needed
						 */
						?>
					<br>
					<div class="form-group">
						<div class=" col-sm-offset-4 col-sm-4">
							<input class="button expanded" type="submit" name="btnSubmit" value="Confinue" />
						</div>
					</div>
					<?php } ?>
					<br>
				</form>
			</div>

         	</div>
     </div>
 </div>
</body>
</html>