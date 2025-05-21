<?php

namespace App\Domain\Entities;

class PageResponse
{
    private array $offers;
    private int   $currentPage;
    private int   $totalPages;
    private ?int  $nextPage;

    public function __construct(array $offers, int $currentPage, int $totalPages, ?int $nextPage) {
        $this->offers      = $offers;
        $this->currentPage = $currentPage;
        $this->totalPages  = $totalPages;
        $this->nextPage    = $nextPage;
    }

    public static function fromArray(array $data): self {
        $pagination = $data['pagination'];
        return new self(
            $data['data']['offers'],
            $pagination['current_page'],
            $pagination['total_pages'],
            $pagination['next_page']
        );
    }

    public function offers(): array {
        return $this->offers;
    }

    public function hasMorePages(): bool {
        return ! is_null($this->nextPage);
    }

    public function nextPage(): ?int {
        return $this->nextPage;
    }

    public function totalPages(): int {
        return $this->totalPages;
    }
}
