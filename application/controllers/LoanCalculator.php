<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoanCalculator extends CI_Controller
{

    public function index()
    {
        $this->load->helper('url');
        $this->load->view('main');
    }

    public function getPaymentPlan()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            $principal = $_GET["loanAmount"];
            $paybackTimeInYears = $_GET["paybackTime"];
            $loanType = $_GET["loanType"];

            $interestRate = 3.5;

            $monthlyInterestRate = $interestRate / 100.0 / 12.0;
            $numPeriods = $paybackTimeInYears * 12;

            $monthlyPayment = ($principal * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numPeriods));
            $remainingBalance = $principal;
            $interestPay = NULL;
            $principalPay = NULL;

            $plan = "<table class=\"table\"><thead><tr>";
            $plan .= "<th>Month</th><th>Principle Payment</th><th>Interest Payment</th>";
            $plan .= "<th>Total Payment</th><th>Remaning Balance</th>";
            $plan .= "</tr></thead><tbody>";

            for ($i = 1; $i <= $numPeriods; $i++) {
                $interestPay = $remainingBalance * $monthlyInterestRate;
                $principalPay = $monthlyPayment - $interestPay;
                $remainingBalance = $remainingBalance - $principalPay;

                $plan .= "<tr>";
                $plan .= "<td>" . $i . "</td>";
                $plan .= "<td>" . number_format($principalPay, "2", ".", ",") . "</td>";
                $plan .= "<td>" . number_format($interestPay, "2", ".", ",") . "</td>";
                $plan .= "<td>" . number_format($monthlyPayment, "2", ".", ",") . "</td>";
                $plan .= "<td>" . number_format($remainingBalance, "2", ".", ",") . "</td>";
                $plan .= "</tr>";
            }

            $plan .= "</tbody></table>";
            echo $plan;
        }
    }
}
