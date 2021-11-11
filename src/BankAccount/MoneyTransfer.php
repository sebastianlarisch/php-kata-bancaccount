<?php

declare(strict_types=1);

namespace App\BankAccount;

use DateTimeImmutable;

final class MoneyTransfer
{
    public string $date;
    public float $amount;
    public float $balance;

    public function __construct(float $amount, float $balance, string $date = '')
    {
        $this->date = (new DateTimeImmutable($date))->format('Y-m-d');
        $this->balance = $balance;
        $this->amount = $amount;
    }
}
