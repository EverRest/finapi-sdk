<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * &lt;strong&gt;Type:&lt;/strong&gt; Category&lt;br/&gt; The category that this rule assigns to the transactions that it matches
 */
class IbanRuleCategory
{
    /**
     * Category identifier.&lt;br/&gt;&lt;br/&gt;NOTE: Do NOT assume that the identifiers of the global finAPI categories are the same across different finAPI environments. In fact, the identifiers may change whenever a new finAPI version is released, even within the same environment. The identifiers are meant to be used for references within the finAPI services only, but not for hard-coding them in your application. If you need to hard-code the usage of a certain global category within your application, please instead refer to the category name. Also, please make sure to check the &#39;isCustom&#39; flag, which is false for all global categories (if you are not regarding this flag, you might end up referring to a user-specific category, and not the global category).
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Category name
     * @DTA\Data(field="name")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $name;

    /**
     * Identifier of the parent category (if a parent category exists)
     * @DTA\Data(field="parentId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $parent_id;

    /**
     * Name of the parent category (if a parent category exists)
     * @DTA\Data(field="parentName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $parent_name;

    /**
     * Whether the category is a finAPI global category (in which case this field will be false), or the category was created by a user (in which case this field will be true)
     * @DTA\Data(field="isCustom")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_custom;

    /**
     * List of sub-categories identifiers (if any exist)
     * @DTA\Data(field="children")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection382::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection382::class})
     * @var \App\DTO\Collection382|null
     */
    public $children;

}
