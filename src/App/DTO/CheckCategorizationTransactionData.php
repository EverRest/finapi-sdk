<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Transaction data for categorization check
 */
class CheckCategorizationTransactionData
{
    /**
     * Identifier of transaction. This can be any arbitrary string that will be passed back in the response so that you can map the results to the given transactions. Note that the identifier must be unique within the given list of transactions.
     * @DTA\Data(field="transactionId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $transaction_id;

    /**
     * Identifier of account type.&lt;br/&gt;&lt;br/&gt;1 &#x3D; Checking,&lt;br/&gt;2 &#x3D; Savings,&lt;br/&gt;3 &#x3D; CreditCard,&lt;br/&gt;4 &#x3D; Security,&lt;br/&gt;5 &#x3D; Loan,&lt;br/&gt;7 &#x3D; Membership,&lt;br/&gt;8 &#x3D; Bausparen&lt;br/&gt;&lt;br/&gt;
     * @DTA\Data(field="accountTypeId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @DTA\Validator(name="GreaterThan", options={"min":1, "inclusive":true})
     * @DTA\Validator(name="LessThan", options={"max":7, "inclusive":true})
     * @var int|null
     */
    public $account_type_id;

    /**
     * Amount
     * @DTA\Data(field="amount")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $amount;

    /**
     * Purpose. Any symbols are allowed. Maximum length is 2000. Default value: null.
     * @DTA\Data(field="purpose", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $purpose;

    /**
     * Counterpart. Any symbols are allowed. Maximum length is 80. Default value: null.
     * @DTA\Data(field="counterpart", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart;

    /**
     * Counterpart IBAN. Default value: null.
     * @DTA\Data(field="counterpartIban", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_iban;

    /**
     * Counterpart account number. Default value: null.
     * @DTA\Data(field="counterpartAccountNumber", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_account_number;

    /**
     * Counterpart BLZ. Default value: null.
     * @DTA\Data(field="counterpartBlz", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_blz;

    /**
     * Counterpart BIC. Default value: null.
     * @DTA\Data(field="counterpartBic", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_bic;

    /**
     * Merchant category code (for credit card transactions only). May only contain up to 4 digits. Default value: null.
     * @DTA\Data(field="mcCode", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $mc_code;

    /**
     * ZKA business transaction code which relates to the transaction&#39;s type (Number from 0 through 999). Default value: null.
     * @DTA\Data(field="typeCodeZka", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $type_code_zka;

}
