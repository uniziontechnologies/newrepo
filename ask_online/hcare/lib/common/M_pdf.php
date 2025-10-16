<?php 
 // var_dump(ROOT_PATH.'\plugins\mpdf\src\vendor\autoload.php');
 require_once ROOT_PATH.'/plugins/mpdf/vendor/autoload.php';
require_once ROOT_PATH.'/plugins/mpdf/src/Mpdf.php';
 
class M_pdf {
 
    public $param;
    public $pdf;
 
    public function __construct()
    {
        $this->param =$param;
        $this->pdf = new \Mpdf\Mpdf();
    }
}
