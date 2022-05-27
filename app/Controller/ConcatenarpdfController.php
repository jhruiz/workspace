<?php
App::import('Vendor', 'FPDI', array('file' => 'fpdi/fpdi.php'));
App::uses('AppController', 'Controller');
class ConcatenarpdfController extends AppController
{
    public $files = array();

    public function setFiles($files)
    {
        $this->files = $files;
    }

    public function concat($nombreConcat)
    {

        $pdf = new FPDI();

        foreach($this->files AS $file) {
            
            $pageCount = $pdf->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                 $tplIdx = $pdf->ImportPage($pageNo);
                 $s = $pdf->getTemplatesize($tplIdx);
                 $pdf->AddPage($s['w'] > $s['h'] ? 'L' : 'P', array($s['w'], $s['h']));
                 $pdf->useTemplate($tplIdx);
            }
        }
        $pdf->Output($nombreConcat, 'F');
        
    }
}
