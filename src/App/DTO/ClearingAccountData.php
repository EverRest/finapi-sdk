<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * clearing account data
 */
class ClearingAccountData
{
    /**
     * Technical identifier of the clearing account
     * @DTA\Data(field="clearingAccountId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $clearing_account_id;

    /**
     * Name of the clearing account
     * @DTA\Data(field="clearingAccountName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $clearing_account_name;

}
