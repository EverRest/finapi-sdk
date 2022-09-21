<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for list of identifiers of deleted users, and not deleted users (in ascending order)
 */
class UserIdentifiersList
{
    /**
     * @DTA\Data(field="deletedUsers")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection187::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection187::class})
     * @var \App\DTO\Collection187|null
     */
    public $deleted_users;

    /**
     * @DTA\Data(field="nonDeletedUsers")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection188::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection188::class})
     * @var \App\DTO\Collection188|null
     */
    public $non_deleted_users;

}
