<?php

namespace FormRelay\PdfProvider;

use FormRelay\Core\Initialization;
use FormRelay\PdfProvider\DataProvider\PdfDataProvider;

class PdfProviderInitialization extends Initialization
{
    public const DATA_PROVIDERS = [
        PdfDataProvider::class,
    ];
}
