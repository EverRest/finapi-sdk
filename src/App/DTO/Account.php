<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a bank account&#39;s data
 */
class Account
{
    /**
     * Account identifier
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Identifier of the bank connection that this account belongs to
     * @DTA\Data(field="bankConnectionId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $bank_connection_id;

    /**
     * Account name
     * @DTA\Data(field="accountName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $account_name;

    /**
     * Account&#39;s IBAN. Note that this field can change from &#39;null&#39; to a value - or vice versa - any time when the account is being updated. This is subject to changes within the bank&#39;s internal account management.
     * @DTA\Data(field="iban")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $iban;

    /**
     * (National) account number. Note that this value might change whenever the account is updated (for example, leading zeros might be added or removed).
     * @DTA\Data(field="accountNumber")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $account_number;

    /**
     * Account&#39;s sub-account-number. Note that this field can change from &#39;null&#39; to a value - or vice versa - any time when the account is being updated. This is subject to changes within the bank&#39;s internal account management.
     * @DTA\Data(field="subAccountNumber")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $sub_account_number;

    /**
     * Name of the account holder
     * @DTA\Data(field="accountHolderName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $account_holder_name;

    /**
     * Bank&#39;s internal identification of the account holder. Note that if your client has no license for processing this field, it will always be &#39;XXXXX&#39;
     * @DTA\Data(field="accountHolderId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $account_holder_id;

    /**
     * Account&#39;s currency
     * @DTA\Data(field="accountCurrency")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $account_currency;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; AccountType&lt;br/&gt; An account type.&lt;br/&gt;&lt;br/&gt;Checking,&lt;br/&gt;Savings,&lt;br/&gt;CreditCard,&lt;br/&gt;Security,&lt;br/&gt;Loan,&lt;br/&gt;Membership,&lt;br/&gt;Bausparen&lt;br/&gt;&lt;br/&gt;
     * @DTA\Data(field="accountType")
     * @DTA\Strategy(name="Object", options={"type":AccountType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":AccountType::class})
     * @var AccountType|null
     */
    public $account_type;

    /**
     * Current account balance
     * @DTA\Data(field="balance")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $balance;

    /**
     * Current overdraft
     * @DTA\Data(field="overdraft")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $overdraft;

    /**
     * Overdraft limit
     * @DTA\Data(field="overdraftLimit")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $overdraft_limit;

    /**
     * Current available funds. Note that this field is only set if finAPI can make a definite statement about the current available funds. This might not always be the case, for example if there is not enough information available about the overdraft limit and current overdraft.
     * @DTA\Data(field="availableFunds")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $available_funds;

    /**
     * Indicating whether this account is &#39;new&#39; or not. Any newly imported account will have this flag initially set to true, and remain so until you set it to false (see PATCH /accounts/&lt;id&gt;). How you use this field is up to your interpretation, however it is recommended to set the flag to false for all accounts right after the initial import of the bank connection. This way, you will be able recognize accounts that get newly imported during a later update of the bank connection, by checking for any accounts with the flag set to true right after an update.
     * @DTA\Data(field="isNew")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_new;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; AccountInterface&lt;br/&gt; Set of interfaces to which this account is connected
     * @DTA\Data(field="interfaces")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection534::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection534::class})
     * @var \App\DTO\Collection534|null
     */
    public $interfaces;

    /**
     * Whether this account is seized. Note that this information is not received from the bank, but determined by finAPI based on the available account information.
     * @DTA\Data(field="isSeized")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_seized;

}
