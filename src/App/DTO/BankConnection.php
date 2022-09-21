<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a bank connection&#39;s data
 */
class BankConnection
{
    /**
     * Bank connection identifier
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Custom name for the bank connection. You can set this field with the &#39;Edit a bank connection&#39; service, as well as during the initial import of the bank connection. Maximum length is 64.
     * @DTA\Data(field="name")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $name;

    /**
     * Current status of data download (account balances and transactions/securities). The POST /bankConnections/import and POST /bankConnections/&lt;id&gt;/update services will set this flag to IN_PROGRESS before they return. Once the import or update has finished, the status will be changed to READY.
     * @DTA\Data(field="updateStatus")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $update_status;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; CategorizationStatus&lt;br/&gt; Current status of transaction categorization. The asynchronous download process that is triggered by a call of the POST /bankConnections/import and POST /bankConnections/&lt;id&gt;/update services (and also by finAPI&#39;s auto update, if enabled) will set this flag to PENDING once the download has finished and a categorization is scheduled for the imported transactions. A separate categorization thread will then start to categorize the transactions (during this process, the status is IN_PROGRESS). When categorization has finished, the status will be (re-)set to READY. Note that the current categorization status should only be queried after the download has finished, i.e. once the download status has switched from IN_PROGRESS to READY.
     * @DTA\Data(field="categorizationStatus")
     * @DTA\Strategy(name="Object", options={"type":CategorizationStatus::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":CategorizationStatus::class})
     * @var CategorizationStatus|null
     */
    public $categorization_status;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankConnectionInterface&lt;br/&gt; Set of interfaces that are connected for this bank connection.
     * @DTA\Data(field="interfaces")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection519::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection519::class})
     * @var \App\DTO\Collection519|null
     */
    public $interfaces;

    /**
     * Identifiers of the accounts that belong to this bank connection
     * @DTA\Data(field="accountIds")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection520::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection520::class})
     * @var \App\DTO\Collection520|null
     */
    public $account_ids;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankConnectionOwner&lt;br/&gt; Information about the owner(s) of the bank connection
     * @DTA\Data(field="owners")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection521::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection521::class})
     * @var \App\DTO\Collection521|null
     */
    public $owners;

    /**
     * @DTA\Data(field="bank")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\BankConnectionBank::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\BankConnectionBank::class})
     * @var \App\DTO\BankConnectionBank|null
     */
    public $bank;

}
