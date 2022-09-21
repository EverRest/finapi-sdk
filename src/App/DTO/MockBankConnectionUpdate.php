<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Data for a mock bank connection update
 */
class MockBankConnectionUpdate
{
    /**
     * Bank connection identifier
     * @DTA\Data(field="bankConnectionId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $bank_connection_id;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankingInterface&lt;br/&gt; Banking interface to update. If not specified, then first available interface in bank connection will be used.
     * @DTA\Data(field="interface", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":BankingInterface::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":BankingInterface::class})
     * @var BankingInterface|null
     */
    public $interface;

    /**
     * Whether to simulate the case that the update fails due to incorrect banking credentials. Note that there is no real communication to any bank server involved, so you won&#39;t lock your accounts when enabling this flag. Default value is &#39;false&#39;.
     * @DTA\Data(field="simulateBankLoginError", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $simulate_bank_login_error;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; MockAccountData&lt;br/&gt; Mock accounts data. Note that for accounts that exist in a bank connection but that you do not specify in this list, the service will act like those accounts are not received by the bank servers. This means that any accounts that you do not specify here will be marked as deprecated. If you do not specify this list at all, all accounts in the bank connection will be marked as deprecated.
     * @DTA\Data(field="mockAccountsData", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection75::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection75::class})
     * @var \App\DTO\Collection75|null
     */
    public $mock_accounts_data;

}
