<?php
/**
 * By Cleiton Wasen
 * wasenbr at gmail.com
 * Based in http://www.appservnetwork.com/modules.php?name=News&file=article&sid=8
 *
 */
class XlsHelper {

    var $helpers = array();
	var $buffer;
	
    /**
     * set the header configuration
     * @param $filename the xls file name
     */
    function setHeader($filename)
    {
		header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");;
        header("Content-Disposition: attachment;filename=$filename");
        header("Content-Transfer-Encoding: binary ");
    }

    /**
     * write the xls begin of file
     */
    function BOF() {
		$this->buffer = tmpfile();
        fwrite( $this->buffer, pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0));
    }

    /**
     * write the xls end of file
     */
    function EOF() {


        fwrite($this->buffer,  pack("ss", 0x0A, 0x00));
		rewind($this->buffer);
		echo stream_get_contents($this->buffer);  //=> "foobar"
		fclose($this->buffer);
    }

    /**
     * write a number
     * @param $Row row to write $Value (first row is 0)
     * @param $Col column to write $Value (first column is 0)
     * @param $Value number value
     */
    function writeNumber($Row, $Col, $Value) {
        fwrite($this->buffer, pack("sssss", 0x203, 14, $Row, $Col, 0x0));
        fwrite($this->buffer, pack("d", $Value));
    }

    /**
     * write a string label
     * @param $Row row to write $Value (first row is 0)
     * @param $Col column to write $Value (first column is 0)
     * @param $Value string value
     */
    function writeLabel($Row, $Col, $Value) {
        $L = strlen($Value);
        fwrite($this->buffer, pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L));
        fwrite($this->buffer, $Value);
    }

}
?>