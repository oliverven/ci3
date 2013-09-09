<?php  if (!defined('BASEPATH')) die ("Direct script access is not allowed.");


class Ocr extends CI_Controller{

	var $dir;

	function __construct(){
		parent::__construct();
		$this->load->library('tesseract_ocr');

		$this->dir = "C:/xampp/htdocs/ci3/";

	}

	function index(){

		$ocr_text = array();

		$numPages = $this->tesseract_ocr->getNumOfPages("sample.pdf");
		$numPages = 2;
		//Extracting the PDF Pages into .tiff files
		for ($i = 0 ; $i < $numPages ; $i++){
			$this->tesseract_ocr->convertToTiffImage("sample.pdf[$i]");
		}

		//Extracting text from the .tiff files
		for ($i = 0 ; $i < $numPages ; $i++){
			array_push($ocr_text,$this->tesseract_ocr->recognize("sample.pdf[$i].png"));
		}

		for ($i=0;$i<$numPages;$i++){
			echo $ocr_text[$i];
		}
	}
}


?>