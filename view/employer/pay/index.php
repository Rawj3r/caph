<?php

    /*
     * This is an example page of the form fields required for a PayGate PayWeb 3 transaction.
     */

    /*
     * Sessions used here only because we can't get the PayGate ID, Transaction reference and secret key on the result page.
     *
     * First input so we make sure there is nothing in the session.
     */
    session_name('paygate_payweb3_testing_sample');
    session_start();
    session_destroy();

    include_once('../lib/php/global.inc.php');

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
                   <!-- <div class="large-6"> -->
            <!-- echo out the system feedback (error and success messages) -->
           
            <h2 style="float: center;">Make Payment</h2>
            <br><br>
                <form role="form" class="form-horizontal text-left" action="request.php" method="post" name="paygate_initiate_form">
                    <div style="display: none; class="form-group">
                        <label for="PAYGATE_ID" class="col-sm-3 control-label">PayGate ID</label>
                        <div class="col-sm-6">
                            <input type="text" name="PAYGATE_ID" id="PAYGATE_ID" class="form-control" value="71531025243" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="REFERENCE" class="col-sm-3 control-label">Reference</label>
                        <div class="col-sm-6">
                            <input type="text" name="REFERENCE" id="REFERENCE" class="form-control" value="<?php echo generateReference(); ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="AMOUNT" class="col-sm-3 control-label">Amount</label>
                        <div class="col-sm-6">
                            <input type="text" name="AMOUNT" id="AMOUNT" class="form-control" value="100" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="CURRENCY" class="col-sm-3 control-label">Currency</label>
                        <div class="col-sm-6">
                            <input type="text" name="CURRENCY" id="CURRENCY" class="form-control" value="ZAR" />
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label for="RETURN_URL" class="col-sm-3 control-label">Return URL</label>
                        <div class="col-sm-6">
                            <input type="text" name="RETURN_URL" id="RETURN_URL" class="form-control" value="<?php echo $fullPath['protocol'] . $fullPath['host'] . '/' . $root . '/view/employer/pay/result.php'; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="TRANSACTION_DATE" class="col-sm-3 control-label">Transaction Date</label>
                        <div class="col-sm-6">
                            <input type="text" name="TRANSACTION_DATE" id="TRANSACTION_DATE" class="form-control" value="<?php echo getDateTime('Y-m-d H:i:s'); ?>" />
                        </div>
                    </div>
                    <div style="display: none;" class="form-group">
                        <label for="LOCALE" class="col-sm-3 control-label">Locale</label>
                        <div class="col-sm-6">
                            <input type="text" name="LOCALE" id="LOCALE" class="form-control" value="en-za" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="COUNTRY" class="col-sm-3 control-label">Country</label>
                        <div class="col-sm-6">
                            <select name="COUNTRY" id="COUNTRY" class="form-control">
                                <?php echo generateCountrySelectOptions(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="EMAIL" class="col-sm-3 control-label">Customer Email</label>
                        <div class="col-sm-6">
                            <input type="text" name="EMAIL" id="EMAIL" class="form-control" value="caph@holisticadvance.com" />
                        </div>
                    </div>
                    <br>
                    <div style="display: none;" class="form-group">
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="button" class="btn btn-primary btn-block" data-toggle="collapse" data-target="#extraFieldsDiv" aria-expanded="false" aria-controls="extraFieldsDiv">
                                Extra Fields
                            </button>
                        </div>
                    </div>
                    <div id="extraFieldsDiv" class="collapse well well-sm">
                        <div class="form-group">
                            <label for="PAY_METHOD" class="col-sm-3 control-label">Pay Method</label>
                            <div class="col-sm-6">
                                <input type="text" name="PAY_METHOD" id="PAY_METHOD" class="form-control" placeholder="optional" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PAY_METHOD_DETAIL" class="col-sm-3 control-label">Pay Method Detail</label>
                            <div class="col-sm-6">
                                <input type="text" name="PAY_METHOD_DETAIL" id="PAY_METHOD_DETAIL" class="form-control" placeholder="optional" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="NOTIFY_URL" class="col-sm-3 control-label">Notify URL</label>
                            <div class="col-sm-6">
                                <input type="text" name="NOTIFY_URL" id="NOTIFY_URL" class="form-control" placeholder="optional" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="USER1" class="col-sm-3 control-label">User Field 1</label>
                            <div class="col-sm-6">
                                <input type="text" name="USER1" id="USER1" class="form-control" placeholder="optional" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="USER2" class="col-sm-3 control-label">User Field 2</label>
                            <div class="col-sm-6">
                                <input type="text" name="USER2" id="USER2" class="form-control" placeholder="optional" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="USER3" class="col-sm-3 control-label">User Field 3</label>
                            <div class="col-sm-6">
                                <input type="text" name="USER3" id="USER3" class="form-control" placeholder="optional" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="VAULT" class="col-sm-3 control-label">Vault</label>
                            <div class="col-sm-6">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="VAULT" id="VAULTOFF" value="" checked>
                                        No card Vaulting
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="VAULT" id="VAULTNO" value="0">
                                        Don't Vault card
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="VAULT" id="VAULTYES" value="1">
                                        Vault card
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="VAULT_ID" class="col-sm-3 control-label">Vault ID</label>
                            <div class="col-sm-6">
                                <input type="text" name="VAULT_ID" id="VAULT_ID" class="form-control" placeholder="optional" />
                            </div>
                        </div>
                    </div>
                    <div style="display: none" class="form-group">
                        <label for="encryption_key" class="col-sm-3 control-label">Encryption Key</label>
                        <div class="col-sm-6">
                            <input type="text" name="encryption_key" id="encryption_key" class="form-control" value="secret" />
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class=" col-sm-offset-4 col-sm-4">
                            <input type="submit" name="btnSubmit" class="button expanded" value="Proceed" />
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        <!-- </div> -->
    </div>
</div>
</body>
</html>

