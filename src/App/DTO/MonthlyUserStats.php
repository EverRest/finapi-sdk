<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Information about a user&#39;s data or activities for a certain month
 */
class MonthlyUserStats
{
    /**
     * The month that the contained information applies to, in the format &#39;YYYY-MM&#39;.
     * @DTA\Data(field="month")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $month;

    /**
     * Minimum count of bank connections that this user has had at any point during the month.
     * @DTA\Data(field="minBankConnectionCount")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $min_bank_connection_count;

    /**
     * Maximum count of bank connections that this user has had at any point during the month.
     * @DTA\Data(field="maxBankConnectionCount")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $max_bank_connection_count;

}
