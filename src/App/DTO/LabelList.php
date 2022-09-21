<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for labels
 */
class LabelList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Label&lt;br/&gt; Labels
     * @DTA\Data(field="labels")
     * @DTA\Strategy(name="Object", options={"type":::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":::class})
     * @var \App\DTO\Label[]|null
     */
    public $labels;

}
