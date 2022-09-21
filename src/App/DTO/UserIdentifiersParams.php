<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * User identifiers params
 */
class UserIdentifiersParams
{
    /**
     * @DTA\Data(field="userIds")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection186::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection186::class})
     * @var \App\DTO\Collection186|null
     */
    public $user_ids;

}
