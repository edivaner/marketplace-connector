<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Interfaces\OfferImportServiceInterface;
use App\Services\OfferImportService;
use App\Domain\Interfaces\OfferRepositoryInterface;
use App\Infrastructure\Repositories\EloquentOfferRepository;
use App\UseCases\Contracts\ImportOffersUseCaseInterface;
use App\UseCases\ImportOffersUseCase;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImportOffersUseCaseInterface::class, ImportOffersUseCase::class);
        $this->app->bind(OfferImportServiceInterface::class, OfferImportService::class);
        $this->app->bind(OfferRepositoryInterface::class, EloquentOfferRepository::class);
    }
}