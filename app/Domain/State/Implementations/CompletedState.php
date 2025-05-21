<?php
namespace App\Domain\State\Implementations;

use App\Domain\State\Contracts\ImportStateInterface;
use App\Domain\State\ImportContext;
use Illuminate\Support\Facades\Log;

class CompletedState implements ImportStateInterface
{
    public function handlePage(ImportContext $contexto, int $page): void{

        $contexto->markCompleted();
    }
}

?>