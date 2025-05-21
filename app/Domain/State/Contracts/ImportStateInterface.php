<?php

namespace App\Domain\State\Contracts;

use App\Domain\State\ImportContext;

interface ImportStateInterface
{
    public function handlePage(ImportContext $context, int $page): void;
}