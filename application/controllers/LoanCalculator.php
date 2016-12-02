<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoanCalculator extends CI_Controller
{

    public function index()
    {
        $this->load->helper('url');
        $loans = $this->config->item('loans');
        $data = array(
            'loans' => $loans
        );
        $this->load->view('main', $data);
    }

    public function getPaymentPlan()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            if (empty($_GET["loanAmount"]) || empty($_GET["paybackTime"]) || empty($_GET["loanType"])) {
                return;
            }

            $principal = $_GET["loanAmount"];
            $paybackTimeInYears = $_GET["paybackTime"];
            $loanType = $_GET["loanType"];
            $interestRate = $this->config->item('loans')[$loanType]['interestRate'];

            $this->load->model('CloseEndLoan');
            $loan = new CloseEndLoan($loanType, $interestRate);
            $paymentPlan = $loan->getPaymentPlan($principal, $paybackTimeInYears);
            $totalInterestPay = $paymentPlan['totalInterestPay'];
            $numPeriods = count($paymentPlan);

            $info = "<div><p>Interest Rate Per Year: " . $interestRate . "</p>";
            $info .= "<p>Total Interest Payment: " . number_format($totalInterestPay, "2", ".", ",") . "</p></div>";
            echo $info;

            $plan = "<table class=\"table\"><thead><tr>";
            $plan .= "<th>Month</th><th>Monthly Payment</th><th>Principle Payment</th>";
            $plan .= "<th>Interest Payment</th><th>Remaning Balance</th>";
            $plan .= "</tr></thead><tbody>";
            for ($i = 1; $i < $numPeriods; $i++) {
                $plan .= "<tr>";
                $plan .= "<td>" . $i . "</td>";
                $plan .= "<td>" . number_format($paymentPlan[$i]['monthlyPayment'], "2", ".", ",") . "</td>";
                $plan .= "<td>" . number_format($paymentPlan[$i]['principalPayment'], "2", ".", ",") . "</td>";
                $plan .= "<td>" . number_format($paymentPlan[$i]['interestPayment'], "2", ".", ",") . "</td>";
                $plan .= "<td>" . number_format($paymentPlan[$i]['remainingBalance'], "2", ".", ",") . "</td>";
                $plan .= "</tr>";
            }
            $plan .= "</tbody></table>";
            echo $plan;
        }
    }
}
