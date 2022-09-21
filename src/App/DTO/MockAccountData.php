<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Mock account data
 */
class MockAccountData
{
    /**
     * Account identifier
     * @DTA\Data(field="accountId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $account_id;

    /**
     * The balance that this account should be set to.&lt;br/&gt;&lt;br/&gt;&lt;b&gt;NOTE&lt;/b&gt;:&lt;br/&gt;&amp;bull; If the specified balance does not add up to the account&#39;s current balance plus the sum of the &#39;newTransactions&#39;, then finAPI will fix the balance deviation with the insertion of an adjusting entry (&#39;Zwischensaldo&#39; transaction).&lt;br/&gt;&amp;bull; This service is not calculating exchange rates for transactions, so if &#39;newTransactions&#39; contains any transactions with a currency different to the account&#39;s currency, then the balance deviation might get calculated incorrectly.
     * @DTA\Data(field="accountBalance")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $account_balance;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; NewTransaction&lt;br/&gt; New transactions that should be imported into the account (at most 1000 transactions at once). Please make sure that the value you pass in the &#39;accountBalance&#39; field equals the current account balance plus the sum of the new transactions that you pass here, otherwise finAPI will detect a deviation in the balance and might add an adjusting entry (&#39;Zwischensaldo&#39; transaction). &lt;br/&gt;Please also note that it is not guaranteed that all transactions that you pass here will actually get imported. More specifically, finAPI will ignore any transactions whose booking date is prior to the date of the last successful account update minus 10 days (which is the default &#39;update window&#39; that finAPI uses when importing new transactions). Also, finAPI will ignore any transactions that are considered duplicates of already existing transactions within the update window. This is the case for instance when you try to import a new transaction with the same booking date and same amount as an already existing transaction. In such cases, you might get an adjusting entry too (&#39;Zwischensaldo&#39; transaction), as your given balance might not add up to the transactions that will exist in the account after the update.
     * @DTA\Data(field="newTransactions", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection74::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection74::class})
     * @var \App\DTO\Collection74|null
     */
    public $new_transactions;

}
