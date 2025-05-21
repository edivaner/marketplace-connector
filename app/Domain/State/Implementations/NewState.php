<?php
namespace App\Domain\State\Implementations;

use App\Domain\State\Contracts\ImportStateInterface;
use App\Domain\State\ImportContext;

class NewState implements ImportStateInterface{
    
    public function handlePage(ImportContext $contexto, int $page): void {
        $contexto->setState(new ImportingState());
        $contexto->proceed($page);
    }
}
?>