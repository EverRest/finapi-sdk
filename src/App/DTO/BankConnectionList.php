<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for data of multiple bank connections
 */
class BankConnectionList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankConnection&lt;br/&gt; List of bank connections
     * @DTA\Data(field="connections")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection522::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection522::class})
     * @var \App\DTO\Collection522|null
     */
    public $connections;

}
