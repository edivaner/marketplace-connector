<?php

namespace App\Domain\Entities;

class OfferDetail
{
    private string $id;
    private string $title;
    private string $description;
    private string $status;
    private int    $stock;

    public function __construct(string $id, string $title, string $description, string $status, int $stock) {
        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
        $this->status      = $status;
        $this->stock       = $stock;
    }

    public static function fromArray(array $data): self {
        return new self(
            (string) $data['id'],
            $data['title'],
            $data['description'],
            $data['status'],
            (int) $data['stock']
        );
    }

    public function id(): string {
        return $this->id;
    }

    public function title(): string {
        return $this->title;
    }

    public function description(): string {
        return $this->description;
    }

    public function status(): string {
        return $this->status;
    }

    public function stock(): int {
        return $this->stock;
    }
}
