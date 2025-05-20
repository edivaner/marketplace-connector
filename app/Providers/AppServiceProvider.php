<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\UseCases\Contracts\ImportOffersUseCaseInterface;
use App\UseCases\ImportOffersUseCase;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImportOffersUseCaseInterface::class, ImportOffersUseCase::class);
    }
}
