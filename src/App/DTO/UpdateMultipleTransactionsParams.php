<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Update specific transactions parameters
 */
class UpdateMultipleTransactionsParams
{
    /**
     * Whether this transactions should be flagged as &#39;new&#39; or not. Any newly imported transaction will have this flag initially set to true. How you use this field is up to your interpretation. For example, you might want to set it to false once a user has clicked on/seen the transaction.
     * @DTA\Data(field="isNew", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_new;

    /**
     * You can set this field only to &#39;false&#39;. finAPI marks transactions as a potential duplicates  when its internal duplicate detection algorithm is signaling so. Transactions that are flagged as duplicates can be deleted by the user. To prevent the user from deleting original transactions, which might lead to incorrect balances, it is not possible to manually set this flag to &#39;true&#39;.
     * @DTA\Data(field="isPotentialDuplicate", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_potential_duplicate;

    /**
     * Identifier of the new category to apply to the transaction. When updating the transaction&#39;s category, the category&#39;s fields &#39;id&#39;, &#39;name&#39;, &#39;parentId&#39;, &#39;parentName&#39;, and &#39;isCustom&#39; will all get updated. To clear the category for the transaction, the categoryId field must be passed with value 0.
     * @DTA\Data(field="categoryId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $category_id;

    /**
     * This field is only regarded when the field &#39;categoryId&#39; is set. It controls whether finAPI&#39;s categorization system should learn from the given categorization(s). If set to &#39;true&#39;, then the user&#39;s categorization rules will be updated so that similar transactions will get categorized accordingly in future. If set to &#39;false&#39;, then the service will simply change the category of the given transaction(s), without updating the user&#39;s categorization rules. The field defaults to &#39;true&#39; if not specified.
     * @DTA\Data(field="trainCategorization", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $train_categorization;

    /**
     * Identifiers of labels to apply to the transaction. To clear transactions&#39; labels, pass an empty array of identifiers: &#39;[]&#39;
     * @DTA\Data(field="labelIds", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection302::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection302::class})
     * @var \App\DTO\Collection302|null
     */
    public $label_ids;

    /**
     * A comma-separated list of transaction identifiers. If specified, then only transactions whose identifier match any of the given identifiers will be regarded. The maximum number of identifiers is 100.
     * @DTA\Data(field="ids", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection303::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection303::class})
     * @var \App\DTO\Collection303|null
     */
    public $ids;

    /**
     * A comma-separated list of account identifiers. If specified, then only transactions whose account&#39;s identifier is included in this list will be regarded.
     * @DTA\Data(field="accountIds", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection304::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection304::class})
     * @var \App\DTO\Collection304|null
     */
    public $account_ids;

}
