<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for parameters for the execution of a submitted SEPA direct debit order
 */
class ExecuteSepaDirectDebitParams
{
    /**
     * Identifier of the bank account that you want to transfer money to
     * @DTA\Data(field="accountId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $account_id;

    /**
     * Banking TAN that the user received from the bank for executing the direct debit order. The field is required if you are licensed to perform SEPA direct debits yourself. Otherwise, i.e. when finAPI&#39;s Web Form flow is required, the Web Form will deal with executing the service itself.
     * @DTA\Data(field="bankingTan", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $banking_tan;

}
