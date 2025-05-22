<?php

namespace App\Domain\Entities;

class PageResponse
{
    private array $offers;
    private int   $currentPage;
    private int   $totalPages;
    private ?int  $nextPage;

    /**
     * Construtor da classe PageResponse.
     *
     * @param array $offers
     * @param int $currentPage
     * @param int $totalPages
     * @param int|null $nextPage
     */
    public function __construct(array $offers, int $currentPage, int $totalPages, ?int $nextPage) {
        $this->offers      = $offers;
        $this->currentPage = $currentPage;
        $this->totalPages  = $totalPages;
        $this->nextPage    = $nextPage;
    }

    /**
     * Cria uma instância de PageResponse a partir de um array.
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self {
        // Extrai ofertas e metadados de paginação
        $offers     = $data['data']['offers'] ?? [];
        $pagination = $data['pagination'] ?? [];

        $current = isset($pagination['current_page']) ? (int) $pagination['current_page'] : 1;
        $total   = isset($pagination['total_pages'])  ? (int) $pagination['total_pages']  : 1;

        // Calcula a próxima página
        $next = ($current < $total) ? $current + 1 : null;

        return new self(
            $offers,
            $current,
            $total,
            $next
        );
    }

    /**
     * Retorna a lista de ofertas.
     *
     * @return array
     */
    public function offers(): array {
        return $this->offers;
    }

    /**
     * Retorna a página atual.
     *
     * @return int
     */
    public function hasMorePages(): bool {
        return ! is_null($this->nextPage);
    }

    /**
     * Retorna a próxima página.
     *
     * @return int|null
     */
    public function nextPage(): ?int {
        return $this->nextPage;
    }

    /**
     * Retorna o total de páginas.
     *
     * @return int
     */
    public function totalPages(): int {
        return $this->totalPages;
    }
}
