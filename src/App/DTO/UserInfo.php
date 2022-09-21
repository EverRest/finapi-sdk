<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for user information
 */
class UserInfo
{
    /**
     * User&#39;s identifier.
     * @DTA\Data(field="userId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $user_id;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;User&#39;s registration date.
     * @DTA\Data(field="registrationDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $registration_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;User&#39;s deletion date. May be null if the user has not been deleted.
     * @DTA\Data(field="deletionDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $deletion_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;User&#39;s last active date. May be null if the user has not yet logged in.
     * @DTA\Data(field="lastActiveDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $last_active_date;

    /**
     * Number of bank connections that currently exist for this user.
     * @DTA\Data(field="bankConnectionCount")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $bank_connection_count;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Latest date of when a bank connection was imported for this user. This field is null when there has never been a bank connection import.
     * @DTA\Data(field="latestBankConnectionImportDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $latest_bank_connection_import_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Latest date of when a bank connection was deleted for this user. This field is null when there has never been a bank connection deletion.
     * @DTA\Data(field="latestBankConnectionDeletionDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $latest_bank_connection_deletion_date;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; MonthlyUserStats&lt;br/&gt; Additional information about the user&#39;s data or activities, broken down in months. The list will by default contain an entry for each month starting with the month of when the user was registered, up to the current month. The date range may vary when you have limited it in the request. &lt;br/&gt;&lt;br/&gt;Please note:&lt;br/&gt;&amp;bull; this field is only set when &#39;includeMonthlyStats&#39; &#x3D; true, otherwise it will be null.&lt;br/&gt;&amp;bull; the list is always ordered from the latest month first, to the oldest month last.&lt;br/&gt;&amp;bull; the list will never contain an entry for a month that was prior to the month of when the user was registered, or after the month of when the user was deleted, even when you have explicitly set a respective date range. This means that the list may be empty if you are requesting a date range where the user didn&#39;t exist yet, or didn&#39;t exist any longer.
     * @DTA\Data(field="monthlyStats")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection481::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection481::class})
     * @var \App\DTO\Collection481|null
     */
    public $monthly_stats;

    /**
     * Whether the user is currently locked (for further information, see the &#39;maxUserLoginAttempts&#39; setting in your client&#39;s configuration). Note that deleted users will always have this field set to &#39;false&#39;.
     * @DTA\Data(field="isLocked")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_locked;

}
