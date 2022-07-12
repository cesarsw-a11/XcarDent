<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Dompdf
{
    public function __construct()
    {
        require_once('../application/third_party/dompdf/dompdf/autoload.inc.php');
    }
}