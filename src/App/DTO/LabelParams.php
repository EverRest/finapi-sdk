<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Label&#39;s name
 */
class LabelParams
{
    /**
     * Label&#39;s name. Maximum length is 288.
     * @DTA\Data(field="name")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[A-Za-z0-9¡-ʯ &\\(\\)\\{\\}\\[\\]\\.:,;\\?!\\+\\-_\\$@#~`\\^€]*/"})
     * @var string|null
     */
    public $name;

}
