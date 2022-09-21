<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Category parameters
 */
class CategoryParams
{
    /**
     * Name of the category. Maximum length is 128.
     * @DTA\Data(field="name")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[A-Za-z0-9¡-ʯ &\\(\\)\\{\\}\\[\\]\\.:,;\\?!\\+\\-_\\$@#~`\\^€]*/"})
     * @var string|null
     */
    public $name;

    /**
     * Identifier of the parent category, if the new category should be created as a sub-category. Must point to a main category in this case. If the new category should be a main category itself, this field must remain unset.
     * @DTA\Data(field="parentId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $parent_id;

}
