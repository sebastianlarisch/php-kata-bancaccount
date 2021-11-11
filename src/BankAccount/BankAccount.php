<?php

declare(strict_types=1);

namespace App\BankAccount;

final class BankAccount
{
    private float $balance;

    /**
     * @var list<MoneyTransfer>
     */
    private array $moneyTransfers = [];

    public function __construct(float $defaultBalance = 0.00)
    {
        $this->balance = $defaultBalance;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @return list<MoneyTransfer>
     */
    public function getMoneyTransfers(): array
    {
        return $this->moneyTransfers;
    }

    public function add(float $amount, string $date = ''): void
    {
        $this->balance += $amount;
        $this->moneyTransfers[] = new MoneyTransfer($amount, $this->balance, $date);
    }

    public function withdraw(float $amount, string $date = ''): void
    {
        $this->balance -= $amount;
        $this->moneyTransfers[] = new MoneyTransfer($amount, $this->balance, $date);
    }
}
