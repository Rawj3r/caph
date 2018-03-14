<?php
	/*
	 * Once the client has completed the transaction on the PayWeb page, they will be redirected to the RETURN_URL set in the initate
	 * Here we will check the transaction status and process accordingly
	 *
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

	/*
	 * insert the returned data as well as the merchant specific data PAYGATE_ID and REFERENCE in array
	 */
	$data = array(
		'PAYGATE_ID'         => $_SESSION['pgid'],
		'PAY_REQUEST_ID'     => $_POST['PAY_REQUEST_ID'],
		'TRANSACTION_STATUS' => $_POST['TRANSACTION_STATUS'],
		'REFERENCE'          => $_SESSION['reference'],
		'CHECKSUM'           => $_POST['CHECKSUM']
	);

	/*
	 * initiate the PayWeb 3 helper class
	 */
	$PayWeb3 = new PayGate_PayWeb3();
	/*
	 * Set the encryption key of your PayGate PayWeb3 configuration
	 */
	$PayWeb3->setEncryptionKey($_SESSION['key']);
	/*
	 * Check that the checksum returned matches the checksum we generate
	 */
	$isValid = $PayWeb3->validateChecksum($data)
?>

<div class="main-container">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
	
			<div class="container">
				<div style="background-color:#80b946; text-align: center; margin-top: 51px; margin-bottom: 15px; padding: 4px;"><strong>Result</strong></div>
				<form role="form" class="form-horizontal text-left" action="query.php" method="post" name="query_paygate_form">
					<div class="form-group" style="display: none;">
						<label for="checksumResult" class="col-sm-3 control-label">Checksum result</label>
						<p id="checksumResult" class="form-control-static"><?php echo (!$isValid ? 'The checksums do not match <i class="glyphicon glyphicon-remove text-danger"></i>' : 'Checksums match OK <i class="glyphicon glyphicon-ok text-success"></i>'); ?></p>
					</div>
		            <hr>
					<div class="form-group" style="display: none;">
						<label for="PAY_REQUEST_ID" class="col-sm-3 control-label">Pay Request ID</label>
						<p id="PAY_REQUEST_ID" class="form-control-static"><?php echo $data['PAY_REQUEST_ID']; ?></p>
					</div>
					<div class="form-group">
						<label for="TRANSACTION_STATUS" class="col-sm-3 control-label">Transaction Status</label>
						<p id="TRANSACTION_STATUS" class="form-control-static"><?php echo $data['TRANSACTION_STATUS']; ?> (<?php echo $PayWeb3->getTransactionStatusDescription($data['TRANSACTION_STATUS']) ?>)</p>
					</div>
					<div class="form-group" style="display: none;">
						<label for="CHECKSUM" class="col-sm-3 control-label">Checksum</label>
						<p id="CHECKSUM" class="form-control-static"><?php echo $data['CHECKSUM']; ?></p>
					</div>

					<!-- Hidden fields to post to the Query service -->
					<input type="hidden" name="PAYGATE_ID" value="<?php echo $data['PAYGATE_ID']; ?>" />
					<input type="hidden" name="PAY_REQUEST_ID" value="<?php echo $data['PAY_REQUEST_ID']; ?>" />
					<input type="hidden" name="REFERENCE" value="<?php echo $data['REFERENCE']; ?>" />
					<input type="hidden" name="encryption_key" value="<?php echo $_SESSION['key']; ?>" />
					<!-- -->

					<div class="form-group">
						<div style="display: none;" class="col-sm-offset-4 col-sm-2">
							<input type="submit" class="btn btn-success btn-block" value="Query PayGate" name="btnSubmit">
						</div>
						<div class="col-sm-2">
							<a href="index.php" class="button expanded">New Transaction</a>
						</div>
					</div>
				</form>
			</div>
        </div>
    </div>
</div>