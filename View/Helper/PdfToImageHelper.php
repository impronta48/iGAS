<?php 
App::uses('AppHelper', 'View/Helper');

class PdfToImageHelper extends AppHelper{

	/**
	 * From a PDF to an image using imagick, if this method see that given pdf was never
	 * converted in wanted out image, try to convert given pdf and store the resulting image
	 * in a dir called "converted". Resulting image will have a name like pdfname.pdf.png
	 *
	 * @param string containing the pdf file path
	 * @param integer start page, default 0 (pages start from 0, so page 0 is the first page)
	 * @param integer how many pages you want print starting from $startPage, not yet used, default 1 page
	 * @param string $outExtension default png
	 * @return void
	 */
	public function pdfToImageImagick($pdfFile, $startPage = 0, $howManyPages = 1, $outExtension = 'png'){
		$pdfPathArray=explode(DS,$pdfFile);
		$pdfPathArray[]=$pdfPathArray[count($pdfPathArray)-1];
		$pdfPathArray[count($pdfPathArray)-2]='converted';
		$outFile=implode(DS,$pdfPathArray);
		$outFile.='.'.$outExtension;
		if(!file_exists($outFile)){
			$imagick = New Imagick;
			if(!is_dir(dirname($outFile))){
				mkdir(dirname($outFile));
			}
			try{
				$imagick->readImage($pdfFile.'['.$startPage.']');
				$imagick->writeImage($outFile); 
			} catch (Exception $e){
				echo $e->getmessage();
			}
		}
	}

	/**
	 * Undocumented function not well tested
	 *
	 * @param string $pdfFile
	 * @param integer $startPage
	 * @param integer $howManyPages
	 * @param string $outExtension
	 * @return string
	 */
	public function pdfToImageGhostScript($pdfFile, $startPage = 0, $howManyPages = 1, $outExtension = 'png'){
        $ghostscriptPath = 'C:\Program Files (x86)\gs\gs9.26\bin';
		//$source_path = $directory.'input/'.escapeshellarg($pdf_file);
		//$destination_path = $directory.'output/'.escapeshellarg($destination_file);
		// check current OS
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$command = $ghostscriptPath.'/gswin32.exe -q -sDEVICE='.$outExtension.'alpha -dBATCH -dNOPAUSE -dFirstPage='.(int)$startPage.' -dLastPage='.(int)($startPage+$howManyPages).' -r150x150 -sOutputFile='.escapeshellarg($pdfFile).'.'.$outExtension.' '.escapeshellarg($pdfFile);
		}else{
			$command = 'gs -q -sDEVICE='.$outExtension.'alpha -dBATCH -dNOPAUSE -dFirstPage='.(int)$startPage.' -dLastPage='.(int)($startPage+$howManyPages).' -r150x150 -sOutputFile='.escapeshellarg($pdfFile).'.'.$outExtension.' '.escapeshellarg($pdfFile);
		}
		echo $command;
		exec($command, $retArr, $retVal);
		
		if(empty($retVal)){
			return 'Success';
		}
		else{
			return 'Error occured while converting the file using below command. <br />'.$command;
		}
	}

	/**
	 * Undocumented function
	 *
	 * @return string
	 */
	public function test(){
		return "ASD";
	}

}
?>