<?php

namespace FormRelay\Core\DataProvider;

use FormRelay\Core\Model\Submission\SubmissionInterface;
use FormRelay\Core\Request\RequestInterface;

class PdfDataProvider extends DataProvider
{
	protected function processContext(SubmissionInterface $submission, RequestInterface $request)
	{
	}

	protected function process(SubmissionInterface $submission)
	{
	}

	public static function getDefaultConfiguration(): array
	{
	}
}
