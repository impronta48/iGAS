<?php  
//info from https://www.syahzul.com/2012/11/13/how-to-generate-pdf-in-cakephp-2-x-with-dompdf/
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('debugKeepTemp', true);
$contxt = stream_context_create([
  'ssl' => [
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
  ]
]);
$dompdf = new Dompdf($options);
$dompdf->setHttpContext($contxt);
$dompdf->set_paper = 'A4';
$dompdf->load_html($content_for_layout);
$dompdf->render();
echo $dompdf->output();
$this->response->type('application/pdf');
$this->response->download($name);
