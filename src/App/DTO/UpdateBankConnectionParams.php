<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for bank connection update parameters
 */
class UpdateBankConnectionParams
{
    /**
     * Bank connection identifier
     * @DTA\Data(field="bankConnectionId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $bank_connection_id;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankingInterface&lt;br/&gt; The interface to use for connecting with the bank.
     * @DTA\Data(field="interface", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":BankingInterface::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":BankingInterface::class})
     * @var BankingInterface|null
     */
    public $interface;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; LoginCredential&lt;br/&gt; Set of login credentials. Must be passed in combination with the &#39;interface&#39; field, if the credentials have not been previously stored. The labels that you pass must match with the login credential labels that the respective interface defines. finAPI will combine the given credentials with any credentials that it has stored. You can leave this field unset in case finAPI has stored all required credentials.
     * @DTA\Data(field="loginCredentials", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection233::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection233::class})
     * @var \App\DTO\Collection233|null
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
     * Whether new accounts that have not yet been imported will be imported or not. Default is false. &lt;br/&gt;&lt;br/&gt;NOTES:&lt;br/&gt;&amp;bull; For best performance of the bank connection update, you should not enable this flag unless you really expect new accounts to be available in the connection. It is recommended to let your users tell you through your application when they want the service to look for new accounts.&lt;br/&gt;&amp;bull; If you have imported an interface using a limited set of account types, you would import all other accounts (e.g. security accounts or credit cards) by setting &lt;code&gt;importNewAccounts&lt;/code&gt; to &lt;code&gt;true&lt;/code&gt;. To avoid importing account types that you are not interested in, make sure to keep this field unset (or set to false) for the update.
     * @DTA\Data(field="importNewAccounts", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $import_new_accounts;

    /**
     * Whether to skip the download of transactions and securities or not. If set to true, then finAPI will download just the accounts list with the accounts&#39; information (like account name, number, holder, etc), as well as the accounts&#39; balances (if possible), but skip the download of transactions and securities. Default is false.&lt;br/&gt;&lt;br/&gt;NOTES:&lt;br/&gt;&amp;bull; Setting this flag to true is only meant to be used if A) you generally never download positions, because you are only interested in the accounts list and/or balances, or B) you want to get just the list of accounts in a first step, and then delete unwanted accounts from the bank connection, before you trigger another update with transactions download. This approach allows you to download transactions only for the accounts that you want.&lt;br/&gt;&amp;bull; If you skip the download of transactions and securities during an import or update, you can still download them on a later update (though you might not get all positions at a later point, because the date range in which the bank servers provide this data is usually limited).&lt;br/&gt;&amp;bull; If an account already had any positions imported before an update, and you skip the positions download in the update, then the account&#39;s updated balance might not add up to the set of transactions / security positions. Be aware that certain services (like GET /accounts/dailyBalances) may give incorrect results for accounts in such a state.&lt;br/&gt;&amp;bull; If this bank connection is updated via finAPI&#39;s automatic batch update, then transactions and security positions (of already imported accounts) &lt;u&gt;will&lt;/u&gt; be downloaded in any case!&lt;br/&gt;&amp;bull; For security accounts, skipping the downloading of the securities might result in the account&#39;s balance also not being downloaded.&lt;br/&gt;&amp;bull; For Bausparen accounts, this field is ignored. finAPI will always download transactions for Bausparen accounts.&lt;br/&gt;
     * @DTA\Data(field="skipPositionsDownload", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $skip_positions_download;

    /**
     * Whether to load/refresh information about the bank connection owner(s) - see field &#39;owners&#39;. Default value is &#39;false&#39;. Note that owner data is NOT loaded/refreshed during finAPI&#39;s automatic bank connection update.
     * @DTA\Data(field="loadOwnerData", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $load_owner_data;

    /**
     * @DTA\Data(field="accountTypes", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection234::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection234::class})
     * @var \App\DTO\Collection234|null
     */
    public $account_types;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; AccountReference&lt;br/&gt; List of accounts for which access is requested from the bank. It may only be passed if the bank interface has the DETAILED_CONSENT property set. if omitted, finAPI will use the list of existing accounts. Note that the parameter is still required if you want to import new accounts (i.e. call with importNewAccounts&#x3D;true).
     * @DTA\Data(field="accountReferences", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection235::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection235::class})
     * @var \App\DTO\Collection235|null
     */
    public $account_references;

    /**
     * Must only be passed when the used interface has the property REDIRECT_APPROACH. The user will be redirected to the given URL from the bank&#39;s website after completing the bank login and (possibly) the SCA.
     * @DTA\Data(field="redirectUrl", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $redirect_url;

    /**
     * @DTA\Data(field="multiStepAuthentication", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\ConnectInterfaceParamsMultiStepAuthentication::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\ConnectInterfaceParamsMultiStepAuthentication::class})
     * @var \App\DTO\ConnectInterfaceParamsMultiStepAuthentication|null
     */
    public $multi_step_authentication;

}
