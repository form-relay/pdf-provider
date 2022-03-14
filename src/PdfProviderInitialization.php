<?php

namespace FormRelay\PdfProvider;

use FormRelay\Core\Initialization;
use FormRelay\Core\Service\RegistryInterface;
use FormRelay\Request\RequestInitialization;
use FormRelay\PdfProvider\DataProvider\PdfDataProvider;

class PdfProviderInitialization extends Initialization
{
    const DATA_PROVIDERS = [
        PdfDataProvider::class,
    ];

    public static function initialize(RegistryInterface $registry)
    {
        RequestInitialization::initialize($registry);
        parent::initialize($registry);
    }
}
