<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for notification rules
 */
class NotificationRuleList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; NotificationRule&lt;br/&gt; List of notification rules
     * @DTA\Data(field="notificationRules")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection132::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection132::class})
     * @var \App\DTO\Collection132|null
     */
    public $notification_rules;

}
