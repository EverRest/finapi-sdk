<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Data for mock bank connection updates
 */
class MockBatchUpdateParams
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; MockBankConnectionUpdate&lt;br/&gt; List of mock bank connection updates
     * @DTA\Data(field="mockBankConnectionUpdates")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection76::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection76::class})
     * @var \App\DTO\Collection76|null
     */
    public $mock_bank_connection_updates;

    /**
     * Whether this call should trigger the dispatching of notifications. Default is &#39;false&#39;.
     * @DTA\Data(field="triggerNotifications", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $trigger_notifications;

}
