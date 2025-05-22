<?php

namespace App\DTOs;

class HubOfferDto
{
    /**
     * Construtor da classe HubOfferDto.
     *
     * @param string $title
     * @param string $description
     * @param string $status
     * @param int    $stock
     */
    public function __construct(
        private string $title,
        private string $description,
        private string $status,
        private int    $stock,
    ) {}

    /**
     * Cria uma instância de HubOfferDto a partir de um array.
     *
     * @param array $data
     * @return self
     */
    public function title(): string {
        return $this->title;
    }

    /**
     * Cria uma instância de HubOfferDto a partir de um array.
     *
     * @param array $data
     * @return self
     */
    public function description(): string {
        return $this->description;
    }

    /**
     * Cria uma instância de HubOfferDto a partir de um array.
     *
     * @param array $data
     * @return self
     */
    public function status(): string {
        return $this->status;
    }

    /**
     * Cria uma instância de HubOfferDto a partir de um array.
     *
     * @param array $data
     * @return self
     */
    public function stock(): int {
        return $this->stock;
    }

    /**
     * Serializa o DTO para um array compatível com o payload esperado pelo HUB.
     */
    public function toPayload(): array {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'stock'       => $this->stock,
        ];
    }
}
