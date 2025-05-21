<?php
namespace App\Domain\State\Implementations;

use App\Domain\Interfaces\OfferImportServiceInterface;
use App\Domain\State\Contracts\ImportStateInterface;
use App\Domain\State\ImportContext;
use Illuminate\Support\Facades\Log;

class ImportingState implements ImportStateInterface{

    public function handlePage(ImportContext $contexto, int $page): void
    {
        // pagina de mock
        $service = app(OfferImportServiceInterface::class);
        $response = $service->getPage($page);

        $contexto->setTotalPages($response->totalPages());

        // dispara o job de importação de pagina
        $contexto->dispatchPageJob($page);

        // verificar se tem mais paginas
        if($contexto->hasMorePages()){
            $contexto->proceed($page + 1);
        }else {
            $contexto->setState(new CompletedState());
            $contexto->getState()->handlePage($contexto, $page);
        }
    }
}
?>