<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Loan Calculator</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">

</head>
<body>

<div id="container">

    <div class="jumbotron text-center">
        <h1>Loan Calculator</h1>
        <p>Calculate your fixed rate loan and see the monthly payback plan</p>

        <form id="loanForm" method="get">
            <div class="form-inline">
                <div class="form-group">
                    <label for="loanAmount">Loan Amount: </label>
                    <input name="loanAmount" id="laonAmount" type="number" min="1" max="1000000""/>
                </div>
                <div class="form-group">
                    <label for="paybackTime">Payback Time in Years: </label>
                    <input name="paybackTime" id="paybackTime" type="number" min="1" max="70" step="1""/>
                </div>
                <div class="form-group">
                    <label for="loanType">Loan Type:</label>
                    <select name="loanType" class="form-control" id="loanType"
                            style="max-width: 200px; display: inline">
                        <?php
                        foreach ($loans as $loan) :?>
                            <option value="<?php echo $loan['id']; ?>"> <?php echo $loan['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" class="btn btn-info"
                       value="Generate Payment Plan" onclick="getPaymentPlan()">
            </div>
        </form>

    </div>

    <div id="paymentPlan" class="container">
    </div>

</div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type='text/javascript' src="<?php echo base_url(); ?>js/app.js"></script>

</html>