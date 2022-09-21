<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Additional, PayPal-specific transaction data. This field is only set for transactions that belong to an account of the PayPal bank.
 */
class PaypalTransactionData
{
    /**
     * Invoice Number.
     * @DTA\Data(field="invoiceNumber")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $invoice_number;

    /**
     * Fee value.
     * @DTA\Data(field="fee")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $fee;

    /**
     * Net value.
     * @DTA\Data(field="net")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $net;

}
