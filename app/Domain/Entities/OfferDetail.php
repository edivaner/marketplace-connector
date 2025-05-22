<?php

namespace App\Domain\Entities;

class OfferDetail
{
    private string $id;
    private string $title;
    private string $description;
    private string $status;
    private int    $stock;

    /**
     * Construtor da classe OfferDetail.
     *
     * @param string $id
     * @param string $title
     * @param string $description
     * @param string $status
     * @param int $stock
     */
    public function __construct(string $id, string $title, string $description, string $status, int $stock) {
        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
        $this->status      = $status;
        $this->stock       = $stock;
    }

    /**
     * Cria uma instância de OfferDetail a partir de um array.
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self {
        return new self(
            (string) $data['id'],
            $data['title'],
            $data['description'],
            $data['status'],
            (int) $data['stock']
        );
    }

    /**
     * Retorna o ID da oferta.
     *
     * @return string
     */
    public function id(): string {
        return $this->id;
    }

    /**
     * Retorna o título da oferta.
     *
     * @return string
     */
    public function title(): string {
        return $this->title;
    }

    /**
     * Retorna a descrição da oferta.
     *
     * @return string
     */
    public function description(): string {
        return $this->description;
    }

    /**
     * Retorna o status da oferta.
     *
     * @return string
     */
    public function status(): string {
        return $this->status;
    }

    /**
     * Retorna o estoque da oferta.
     *
     * @return int
     */
    public function stock(): int {
        return $this->stock;
    }
}
