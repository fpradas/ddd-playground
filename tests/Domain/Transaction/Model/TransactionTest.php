<?php

namespace Tests\Leos\Domain\Transaction\Model;

use Leos\Domain\Payment\Model\Deposit;
use Leos\Domain\Payment\ValueObject\DepositDetails;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Transaction\ValueObject\TransactionType;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class TransactionTest
 *
 * @package Leos\Domain\Transaction\Model
 */
class TransactionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testGetters()
    {

        $wallet = new Wallet(new WalletId(), new Credit(0), new Credit(0));

        $currency = new Currency('EUR', 1);

        $transaction = new Deposit(
            $wallet,
            new Money(50.00, $currency),
            new DepositDetails('paypal')
        );

        self::assertTrue(null !== $transaction->id());
        self::assertEquals($wallet, $transaction->wallet());
        self::assertEquals(TransactionType::DEPOSIT, (string) $transaction->type());
        self::assertEquals(0, $transaction->prevReal()->amount());
        self::assertEquals(0, $transaction->prevBonus()->amount());
        self::assertEquals(5000, $transaction->operationReal());
        self::assertInstanceOf(Money::class, $transaction->realMoney());
        self::assertInstanceOf(Money::class, $transaction->bonusMoney());
        self::assertEquals(0, $transaction->operationBonus());
        self::assertNull($transaction->referralTransaction());
        self::assertEquals($currency->code(), $transaction->currency()->code());
        self::assertNotNull($transaction->createdAt());
        self::assertNull($transaction->updatedAt());
        self::assertNull($transaction->referralTransaction());
    }
}
