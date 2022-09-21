<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Data of a sub-transaction
 */
class SubTransactionParams
{
    /**
     * Amount
     * @DTA\Data(field="amount")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $amount;

    /**
     * Category identifier. If not specified, the original transaction&#39;s category will be applied. If you explicitly want the sub-transaction to have no category, then pass this field with value &#39;0&#39; (zero).
     * @DTA\Data(field="categoryId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $category_id;

    /**
     * Purpose. Maximum length is 2000. If not specified, the original transaction&#39;s value will be applied.
     * @DTA\Data(field="purpose", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[A-Za-z0-9¡-ʯ &\\(\\)\\{\\}\\[\\]\\.:,;\\?!\\+\\-_\\$@#~`\\^€]*/"})
     * @var string|null
     */
    public $purpose;

    /**
     * Counterpart. Maximum length is 80. If not specified, the original transaction&#39;s value will be applied.
     * @DTA\Data(field="counterpart", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[A-Za-z0-9¡-ʯ &\\(\\)\\{\\}\\[\\]\\.:,;\\?!\\+\\-_\\$@#~`\\^€]*/"})
     * @var string|null
     */
    public $counterpart;

    /**
     * Counterpart account number. If not specified, the original transaction&#39;s value will be applied.
     * @DTA\Data(field="counterpartAccountNumber", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[A-Za-z0-9¡-ʯ &\\(\\)\\{\\}\\[\\]\\.:,;\\?!\\+\\-_\\$@#~`\\^€]*/"})
     * @var string|null
     */
    public $counterpart_account_number;

    /**
     * Counterpart IBAN. If not specified, the original transaction&#39;s value will be applied.
     * @DTA\Data(field="counterpartIban", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_iban;

    /**
     * Counterpart BIC. If not specified, the original transaction&#39;s value will be applied.
     * @DTA\Data(field="counterpartBic", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_bic;

    /**
     * Counterpart BLZ. If not specified, the original transaction&#39;s value will be applied.
     * @DTA\Data(field="counterpartBlz", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_blz;

    /**
     * List of connected labels. Note that when this field is not specified, then the labels of the original transaction will NOT get applied to the sub-transaction. Instead, the sub-transaction will have no labels assigned to it.
     * @DTA\Data(field="labelIds", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection34::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection34::class})
     * @var \App\DTO\Collection34|null
     */
    public $label_ids;

}
