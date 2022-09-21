<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for securities resources
 */
class SecurityList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Security&lt;br/&gt; List of securities
     * @DTA\Data(field="securities")
     * @DTA\Strategy(name="Object", options={"type":::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":::class})
     * @var \App\DTO\Security[]|null
     */
    public $securities;

}
