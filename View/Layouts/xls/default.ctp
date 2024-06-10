<?php
// Add/define XLS contenttype
$this->response->type(array('xls' => 'application/vnd.ms-excel'));

// Set the response Content-Type to xls
$this->response->type('xls');

// Set the response Content-Disposition to force the download
$this->response->download($name . '.xls');

echo $this->fetch('content');