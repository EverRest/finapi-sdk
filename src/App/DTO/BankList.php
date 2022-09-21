<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for data of multiple banks
 */
class BankList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Bank&lt;br/&gt; Banks
     * @DTA\Data(field="banks")
     * @DTA\Strategy(name="Object", options={"type":::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":::class})
     * @var \App\DTO\Bank[]|null
     */
    public $banks;

}
