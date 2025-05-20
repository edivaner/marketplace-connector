<?php
namespace App\Http\Controllers;

use App\UseCases\Contracts\ImportOffersUseCaseInterface;
use Illuminate\Http\JsonResponse;


class ImportController extends Controller{

    private ImportOffersUseCaseInterface $importOffersUseCase;
    public function __construct(ImportOffersUseCaseInterface $importOffersUseCase){
        $this->importOffersUseCase = $importOffersUseCase;
    }

    public function importOffers(): JsonResponse {
        $returnOffers = $this->importOffersUseCase->execute();

        return response()->json([
            'message' => 'Importação iniciada com sucesso!',
            'offer' => $returnOffers,
        ], 202);
    }
}

?>