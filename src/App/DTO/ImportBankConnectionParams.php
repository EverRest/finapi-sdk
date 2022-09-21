<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for bank connection import parameters
 */
class ImportBankConnectionParams
{
    /**
     * Bank Identifier
     * @DTA\Data(field="bankId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $bank_id;

    /**
     * Custom name for the bank connection. Maximum length is 64. If you do not want to set a name, you can leave this field unset.
     * @DTA\Data(field="name", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $name;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankingInterface&lt;br/&gt; The interface to use for connecting with the bank.
     * @DTA\Data(field="interface", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":BankingInterface::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":BankingInterface::class})
     * @var BankingInterface|null
     */
    public $interface;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; LoginCredential&lt;br/&gt; Set of login credentials. Must be passed in combination with the &#39;interface&#39; field.
     * @DTA\Data(field="loginCredentials", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection255::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection255::class})
     * @var \App\DTO\Collection255|null
     */
    public $login_credentials;

    /**
     * Whether to store the secret login fields. If the secret fields are stored, then updates can be triggered without the involvement of the users, as long as the credentials remain valid and the bank consent has not expired. Note that bank consent will be stored regardless of the field value. Default value is false.
     * @DTA\Data(field="storeSecrets", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $store_secrets;

    /**
     * Whether to skip the download of transactions and securities or not. If set to true, then finAPI will download just the accounts list with the accounts&#39; information (like account name, number, holder, etc), as well as the accounts&#39; balances (if possible), but skip the download of transactions and securities. Default is false.&lt;br/&gt;&lt;br/&gt;NOTES:&lt;br/&gt;&amp;bull; Setting this flag to true is only meant to be used if A) you generally never download positions, because you are only interested in the accounts list and/or balances, or B) you want to get just the list of accounts in a first step, and then delete unwanted accounts from the bank connection, before you trigger another update with transactions download. This approach allows you to download transactions only for the accounts that you want.&lt;br/&gt;&amp;bull; If you skip the download of transactions and securities during an import or update, you can still download them on a later update (though you might not get all positions at a later point, because the date range in which the bank servers provide this data is usually limited).&lt;br/&gt;&amp;bull; If an account already had any positions imported before an update, and you skip the positions download in the update, then the account&#39;s updated balance might not add up to the set of transactions / security positions. Be aware that certain services (like GET /accounts/dailyBalances) may give incorrect results for accounts in such a state.&lt;br/&gt;&amp;bull; If this bank connection is updated via finAPI&#39;s automatic batch update, then transactions and security positions (of already imported accounts) &lt;u&gt;will&lt;/u&gt; be downloaded in any case!&lt;br/&gt;&amp;bull; For security accounts, skipping the downloading of the securities might result in the account&#39;s balance also not being downloaded.&lt;br/&gt;&amp;bull; For Bausparen accounts, this field is ignored. finAPI will always download transactions for Bausparen accounts.&lt;br/&gt;
     * @DTA\Data(field="skipPositionsDownload", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $skip_positions_download;

    /**
     * Whether to load information about the bank connection owner(s) - see field &#39;owners&#39;. Default value is &#39;false&#39;.&lt;br/&gt;&lt;br/&gt;NOTE: This feature is supported only by the WEB_SCRAPER interface.
     * @DTA\Data(field="loadOwnerData", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $load_owner_data;

    /**
     * This setting defines how much of an account&#39;s transactions history will be downloaded whenever a new account is imported. More technically, it depicts the number of days to download transactions for, starting from - and including - the date of the account import. For example, on an account import that happens today, the value 30 would instruct finAPI to download transactions from the past 30 days (including today). The minimum allowed value is 14, the maximum value is 3650. Also possible is the value 0 (which is the default value), in which case there will be no limit to the transactions download and finAPI will try to get all transactions that it can. &lt;br/&gt;&lt;br/&gt;Note:&lt;br/&gt;&amp;bull; There is no guarantee that finAPI will actually download transactions for the entire defined date range, as there may be limitations to the download range (set by the bank or by finAPI, e.g. see ClientConfiguration.transactionImportLimitation). &lt;br/&gt;&amp;bull; This parameter only applies to transactions, not to security positions; For security accounts, finAPI will always download all security positions that it can. &lt;br/&gt;&amp;bull; This setting is stored for each interface individually.&lt;br/&gt;&amp;bull; After an interface has been connected with this setting, there is no way to change the setting for that interface afterwards.&lt;br/&gt;&amp;bull; &lt;b&gt;If you do not limit the download range to a value less than 90 days, the bank is more likely to trigger a strong customer authentication request for the user when finAPI is attempting to download the transactions.&lt;/b&gt;
     * @DTA\Data(field="maxDaysForDownload", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $max_days_for_download;

    /**
     * @DTA\Data(field="accountTypes", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection256::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection256::class})
     * @var \App\DTO\Collection256|null
     */
    public $account_types;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; AccountReference&lt;br/&gt; List of accounts for which access is requested from the bank. It must only be passed if the bank interface has the DETAILED_CONSENT property set.
     * @DTA\Data(field="accountReferences", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection257::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection257::class})
     * @var \App\DTO\Collection257|null
     */
    public $account_references;

    /**
     * @DTA\Data(field="multiStepAuthentication", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\ConnectInterfaceParamsMultiStepAuthentication::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\ConnectInterfaceParamsMultiStepAuthentication::class})
     * @var \App\DTO\ConnectInterfaceParamsMultiStepAuthentication|null
     */
    public $multi_step_authentication;

    /**
     * Must only be passed when the used interface has the property REDIRECT_APPROACH. The user will be redirected to the given URL from the bank&#39;s website after completing the bank login and (possibly) the SCA.
     * @DTA\Data(field="redirectUrl", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $redirect_url;

}
