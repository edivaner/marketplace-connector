<?php
namespace App\Http\Controllers;

use App\UseCases\Contracts\ImportOffersUseCaseInterface;
use Illuminate\Http\JsonResponse;


class ImportController extends Controller{

    /**
     * ImportController constructor.
     *
     * @param ImportOffersUseCaseInterface $importOffersUseCase
     */
    public function __construct(private ImportOffersUseCaseInterface $importOffersUseCase){}

    /**
     * Import offers from the source.
     *
     * @return JsonResponse
     */
    public function importOffers(): JsonResponse {
        $returnOffers = $this->importOffersUseCase->execute();

        return response()->json([
            'message' => 'Importação iniciada com sucesso!',
            'offer' => $returnOffers,
        ], 202);
    }
}

?>