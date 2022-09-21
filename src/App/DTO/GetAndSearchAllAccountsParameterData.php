<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for getAndSearchAllAccounts
 */
class GetAndSearchAllAccountsParameterData
{
    /**
     * A comma-separated list of bank connection identifiers. If specified, then only accounts that relate to the given bank connections will be regarded. If not specified, then all accounts will be regarded.
     * @DTA\Data(subset="query", field="bankConnectionIds", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $bank_connection_ids;

    /**
     * If specified, then only those accounts will be contained in the result whose &#39;accountName&#39;, &#39;iban&#39;, &#39;accountNumber&#39; or &#39;subAccountNumber&#39; contains the given search string (the matching works case-insensitive). If no accounts contain the search string in any of these fields, then the result will be an empty list. NOTE: If the given search string consists of several terms (separated by whitespace), then ALL of these terms must be contained in the searched fields for an account to get included into the result.
     * @DTA\Data(subset="query", field="search", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $search;

    /**
     * If specified, then only accounts whose balance is equal to or greater than the given balance will be regarded. Can contain a positive or negative number with at most two decimal places. Examples: -300.12, or 90.95
     * @DTA\Data(subset="query", field="minBalance", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"float"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"float"})
     * @var float|null
     */
    public $min_balance;

    /**
     * With any API call, you can pass a request ID. The request ID can be an arbitrary string with up to 255 characters. Passing a longer string will result in an error. If you don&#39;t pass a request ID for a call, finAPI will generate a random ID internally. The request ID is always returned back in the response of a service, as a header with name &#39;X-Request-Id&#39;. We highly recommend to always pass a (preferably unique) request ID, and include it into your client application logs whenever you make a request or receive a response (especially in the case of an error response). finAPI is also logging request IDs on its end. Having a request ID can help the finAPI support team to work more efficiently and solve tickets faster.
     * @DTA\Data(subset="header", field="X-Request-Id", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $x_request_id;

    /**
     * A comma-separated list of account identifiers. If specified, then only accounts whose identifier match any of the given identifiers will be regarded. The maximum number of identifiers is 1000.
     * @DTA\Data(subset="query", field="ids", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $ids;

    /**
     * A comma-separated list of account types. If specified, then only accounts that relate to the given types will be regarded. If not specified, then all accounts will be regarded.
     * @DTA\Data(subset="query", field="accountTypes", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @var string[]|null
     */
    public $account_types;

    /**
     * If specified, then only accounts whose balance is equal to or less than the given balance will be regarded. Can contain a positive or negative number with at most two decimal places. Examples: -300.12, or 90.95
     * @DTA\Data(subset="query", field="maxBalance", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"float"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"float"})
     * @var float|null
     */
    public $max_balance;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Upper bound for a account&#39;s last successful update date, e.g. &#39;2016-01-01&#39;. If specified, then only accounts whose &#39;lastSuccessfulUpdate&#39; is equal to or earlier than the given date will be regarded.
     * @DTA\Data(subset="query", field="maxLastSuccessfulUpdate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $max_last_successful_update;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Lower bound for a account&#39;s last successful update date, e.g. &#39;2016-01-01&#39;. If specified, then only accounts whose &#39;lastSuccessfulUpdate&#39; is equal to or later than the given date will be regarded.
     * @DTA\Data(subset="query", field="minLastSuccessfulUpdate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $min_last_successful_update;

}
