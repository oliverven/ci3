<?php


class Tesseract_ocr {

	function __construct(){
		ini_set('MAX_EXECUTION_TIME', -1);
		set_time_limit(0);
		echo "awdawd";
	}

	
	function recognize($image){
		//Generate the output file
		$outputFile = $this->executeTesseract($image);
		//Retrieve the text from the output file
		$recognizedText = $this->readOutputFile($outputFile);
		//Clean up temporary files
		$this->cleanTempFiles($image,$outputFile);
		return $recognizedText;
	}

	function convertToTiffImage($image){
		$tifImage ="temp/$image".'.png';
		$perform = "convert -density 200 -colorspace gray +matte uploads/$image -quality 95 $tifImage";
		exec($perform);
		return $tifImage;
	}

	function executeTesseract($tifImage){
		$tifImage = "temp/$tifImage";
		$outputFile = 'temp/'.'tesseract_ocr_output_'.rand();
		exec("tesseract $tifImage $outputFile nobatch");
		return $outputFile.'.txt';

	}
	function readOutputFile($outputFile){
		return trim(file_get_contents($outputFile));
	}	
	function cleanTempFiles($tifImage, $outputFile){
		unlink('temp/'.$tifImage);
		unlink($outputFile);
	}
	function getNumOfPages($image) 
	{
		$num_pages = false;
	    exec("pdfinfo uploads/$image",$out);
    	if ($out){
    		foreach ($out as $index => $val){
    			if (substr($val,0,5) == "Pages"){
    				$num_pages = substr($val, 7);
    			}
    		}
    	}
    	return $num_pages;
	}	

}


?>