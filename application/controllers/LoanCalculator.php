<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoanCalculator extends CI_Controller {

	public function index()
	{
	    $this->load->helper('url');

        $data['interestRate'] = 3.5;
        $data['a'] = json_encode(array(
            'key' => 'value',
            'key2' => 'value2'
        ));


		$this->load->view('main', $data);
	}

	public function getPaymentPlan()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            $principle = $_GET["loanAmount"];
            $numPeriods = $_GET["paybackTime"];
            $loanType = $_GET["loanType"];

            echo $loanType;
        }
    }
}
