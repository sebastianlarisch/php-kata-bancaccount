<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount;

use App\BankAccount\BankAccount;
use App\BankAccount\MoneyTransfer;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class BankAccountTest extends TestCase
{
    private BankAccount $account;

    public function setUp(): void
    {
        $this->account = new BankAccount();
    }

    public function test_client_has_no_money(): void
    {
        $actual = $this->account->getBalance();

        self::assertEquals(0.00, $actual);
    }

    public function test_account_balance_when_adding_money(): void
    {
        $deposit = 500.00;
        $currentBalance = $this->account->getBalance();
        $this->account->add($deposit);

        $actual = $this->account->getBalance();

        self::assertEquals(500.00, $actual - $currentBalance);
    }

    public function test_account_balance_when_withrawing_money(): void
    {
        $withdraw = 400.00;
        $account = new BankAccount(1000);

        $account->withdraw($withdraw);

        $actual = $account->getBalance();

        self::assertEquals(600.00, $actual);
    }

    public function test_added_date_is_saved_correctly(): void
    {
        $deposit = 400.00;
        $account = new BankAccount(1000);

        $account->withdraw($deposit, '2020-10-12');

        $actual = $account->getMoneyTransfers()[0];

        assert($actual instanceof MoneyTransfer);

        self::assertEquals('2020-10-12', $actual->date);
        self::assertEquals(400.00, $actual->amount);
    }

    public function test_not_adding_date_will_use_current_date(): void
    {
        $deposit = 400.00;
        $account = new BankAccount(1000);

        $account->withdraw($deposit, '');

        $actual = $account->getMoneyTransfers()[0];

        assert($actual instanceof MoneyTransfer);
        $today = (new DateTimeImmutable())->format('Y-m-d');

        self::assertEquals($today, $actual->date);
        self::assertEquals(400.00, $actual->amount);
    }

    public function test_printing_account_statements_are_correct(): void
    {
        $account = new BankAccount(0);

        $account->add(1000.00, '2020-01-11');
        $account->add(2000.00, '2020-01-12');
        $account->withdraw(500.00, '2020-01-15');

        $actual = $account->getMoneyTransfers();

        self::assertEquals('2020-01-11', $actual[0]->date);
        self::assertEquals('2020-01-12', $actual[1]->date);
        self::assertEquals('2020-01-15', $actual[2]->date);

        self::assertEquals('1000.00', $actual[0]->balance);
        self::assertEquals('3000.00', $actual[1]->balance);
        self::assertEquals('2500.00', $actual[2]->balance);
    }
}