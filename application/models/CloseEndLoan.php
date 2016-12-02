<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '\models\Loan.php';

class CloseEndLoan extends Loan
{
    private $interestRate;

    public function __construct($type = NULL, $interestRate = NULL)
    {
        parent::__construct();

        $this->type = $type;
        $this->interestRate = $interestRate;
    }

    public function getPaymentPlan($principal, $paybackTime)
    {
        $monthlyInterestRate = $this->interestRate / 100.0 / 12.0;
        $numPeriods = $paybackTime * 12;
        $monthlyPayment = ($principal * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numPeriods));
        $remainingBalance = $principal;
        $interestPay = NULL;
        $principalPay = NULL;
        $paymentPlan = array();
        $totalInterestPay = 0;

        for ($i = 1; $i <= $numPeriods; $i++) {
            $paymentPlan[$i]['month'] = $i;

            $interestPay = $remainingBalance * $monthlyInterestRate;
            $paymentPlan[$i]['interestPayment'] = $interestPay;
            $totalInterestPay = $totalInterestPay + $interestPay;

            $principalPay = $monthlyPayment - $interestPay;
            $paymentPlan[$i]['principalPayment'] = $principalPay;

            $paymentPlan[$i]['monthlyPayment'] = $monthlyPayment;

            $remainingBalance = $remainingBalance - $principalPay;
            $paymentPlan[$i]['remainingBalance'] = abs($remainingBalance);
        }

        $paymentPlan['totalInterestPay'] = $totalInterestPay;

        return $paymentPlan;
    }
}