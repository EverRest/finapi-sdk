<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Trigger categorization parameters
 */
class TriggerCategorizationParams
{
    /**
     * List of identifiers of the bank connections that you want to trigger categorization for. Leaving the list unset or empty will trigger categorization for all of the user&#39;s bank connections. Please note that if there are no bank connections, then the service will return with HTTP code 422.
     * @DTA\Data(field="bankConnectionIds", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection50::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection50::class})
     * @var \App\DTO\Collection50|null
     */
    public $bank_connection_ids;

}
