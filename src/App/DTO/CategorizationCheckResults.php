<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 */
class CategorizationCheckResults
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; CategorizationCheckResult&lt;br/&gt; List of results
     * @DTA\Data(field="categorizationCheckResult")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection83::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection83::class})
     * @var \App\DTO\Collection83|null
     */
    public $categorization_check_result;

}
