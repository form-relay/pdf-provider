<?php

namespace FormRelay\PdfProvider\DataProvider;

use FormRelay\Core\DataProvider\DataProvider;
use FormRelay\Core\Model\Submission\SubmissionInterface;
use FormRelay\Core\Request\RequestInterface;

class PdfDataProvider extends DataProvider
{
	const KEY_FIELD = 'field';
	const DEFAULT_FIELD = 'pdf_form';
	
	const KEY_PDF_TEMPLATE_PATH = 'pdfTemplatePath';
	const DEFAULT_PDF_TEMPLATE_PATH = '';
	
	const KEY_PDF_OUTPUT_DIR = 'pdfOutputDir';
	const DEFAULT_PDF_OUTPUT_DIR = '';
	
	const KEY_PDF_OUTPUT_NAME = 'pdfOutputName';
	const DEFAULT_PDF_OUTPUT_NAME = '';
	
	const KEY_PDF_FORM_FIELDS = 'pdfFormFields';
	const DEFAULT_PDF_FORM_FIELDS = [];
	
	protected function processContext(SubmissionInterface $submission, RequestInterface $request)
	{
		$this->addToContext($submission, 'pdf_form', $this->generatePdf($submission));
	}
	
	protected function process(SubmissionInterface $submission)
	{
		$this->setFieldFromContext(
			$submission,
			'pdf_form',
			$this->getConfig(static::KEY_FIELD)
		);
	}
	
	public static function getDefaultConfiguration(): array
	{
		return parent::getDefaultConfiguration() + [
			static::KEY_FIELD => static::DEFAULT_FIELD,
		];
	}
	
	private function generatePdf($submission) {
		
		$pdfTemplatePath = $this->getConfig(static::KEY_PDF_TEMPLATE_PATH);
		$pdfOutputDir = $this->getConfig(static::KEY_PDF_OUTPUT_DIR);
		$pdfOutputName = $this->getConfig(static::KEY_PDF_OUTPUT_NAME);
		$pdfFormFields = $this->getConfig(static::KEY_PDF_FORM_FIELDS);
		
		if(!is_array($pdfFormFields) || $pdfOutputDir == '' || $pdfOutputName == '' || $pdfTemplatePath == '' || !file_exists($pdfTemplatePath)) {
			return '';
		}
		
		$tempDir = $this->createUniqueTempDirectory($pdfOutputDir);
		if(!$tempDir) {
			return '';
		}
		$generatedPdf =  $tempDir . $pdfOutputName;
		
		try {
			$pdf = new \FPDM($pdfTemplatePath);
			$pdf->useCheckboxParser = true;
			$pdf->Load($pdfFormFields, true);
			$pdf->Merge();
			$pdf->Output('F', $generatedPdf);
			return $generatedPdf;
		} catch(\Exception $e) {
			return '';
		}
	}
	
	private function createUniqueTempDirectory($dir, $maxTries = 500)
	{
		if (!file_exists($dir)) {
			mkdir($dir);
		}
		$dir .= uniqid('pdf_') . '_';
		$tries = 0;
		for ($tries = 0; $tries < $maxTries && file_exists($dir . $tries); $tries++) {
		}
		$dir .= $tries;
		if (!file_exists($dir) && mkdir($dir)) {
			return $dir;
		}
		return false;
	}
}
