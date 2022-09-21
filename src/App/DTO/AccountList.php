<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for data of multiple bank accounts
 */
class AccountList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Account&lt;br/&gt; List of bank accounts
     * @DTA\Data(field="accounts")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection535::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection535::class})
     * @var \App\DTO\Collection535|null
     */
    public $accounts;

}
