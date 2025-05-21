<?php

namespace App\Domain\State\Implementations;

use App\Domain\State\Contracts\ImportStateInterface;
use App\Domain\State\ImportContext;

class FailedState implements ImportStateInterface
{
    public function handlePage(ImportContext $context, int $page): void {
        $context->markFailed();
    }
}
?>