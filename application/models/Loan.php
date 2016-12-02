<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Loan extends CI_Model
{
    abstract protected function getPaymentPlan($principal, $paybackTime);
}