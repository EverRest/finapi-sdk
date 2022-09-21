<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Resource representing a bank connection interface
 */
class BankConnectionInterface
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankingInterface&lt;br/&gt; Bank interface. Possible values:&lt;br&gt;&lt;br&gt;&amp;bull; &lt;code&gt;WEB_SCRAPER&lt;/code&gt; - means that finAPI will parse data from the bank&#39;s online banking website.&lt;br&gt;&amp;bull; &lt;code&gt;FINTS_SERVER&lt;/code&gt; - means that finAPI will download data via the bank&#39;s FinTS interface.&lt;br&gt;&amp;bull; &lt;code&gt;XS2A&lt;/code&gt; - means that finAPI will download data via the bank&#39;s XS2A interface.&lt;br&gt;
     * @DTA\Data(field="interface")
     * @DTA\Strategy(name="Object", options={"type":BankingInterface::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":BankingInterface::class})
     * @var BankingInterface|null
     */
    public $interface;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; LoginCredentialResource&lt;br/&gt; Login fields for this interface (in the order that we suggest to show them to the user), with their currently stored values. Note that this list always contains all existing login fields for this interface, even when there is no stored value for a field (value will be null in such a case).
     * @DTA\Data(field="loginCredentials")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection517::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection517::class})
     * @var \App\DTO\Collection517|null
     */
    public $login_credentials;

    /**
     * The default two-step-procedure for this interface. Must match one of the available &#39;procedureId&#39;s from the &#39;twoStepProcedures&#39; list. When this field is set, then finAPI will automatically try to select the procedure wherever applicable. Note that the list of available procedures of a bank connection may change as a result of an update of the connection, and if this field references a procedure that is no longer available after an update, finAPI will automatically clear the default procedure (set it to null).
     * @DTA\Data(field="defaultTwoStepProcedureId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $default_two_step_procedure_id;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; TwoStepProcedure&lt;br/&gt; Available two-step-procedures in this interface, used for submitting a money transfer or direct debit request (see /accounts/requestSepaMoneyTransfer or /requestSepaDirectDebit),or for multi-step-authentication during bank connection import or update. The available two-step-procedures mya be re-evaluated each time this bank connection is updated (/bankConnections/update). This means that this list may change as a result of an update.
     * @DTA\Data(field="twoStepProcedures")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection518::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection518::class})
     * @var \App\DTO\Collection518|null
     */
    public $two_step_procedures;

    /**
     * @DTA\Data(field="aisConsent")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\BankConnectionInterfaceAisConsent::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\BankConnectionInterfaceAisConsent::class})
     * @var \App\DTO\BankConnectionInterfaceAisConsent|null
     */
    public $ais_consent;

    /**
     * @DTA\Data(field="lastManualUpdate")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\BankConnectionInterfaceLastManualUpdate::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\BankConnectionInterfaceLastManualUpdate::class})
     * @var \App\DTO\BankConnectionInterfaceLastManualUpdate|null
     */
    public $last_manual_update;

    /**
     * @DTA\Data(field="lastAutoUpdate")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\BankConnectionInterfaceLastAutoUpdate::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\BankConnectionInterfaceLastAutoUpdate::class})
     * @var \App\DTO\BankConnectionInterfaceLastAutoUpdate|null
     */
    public $last_auto_update;

    /**
     * This field indicates whether the user&#39;s attention is required for the next update of the given bank connection interface.&lt;br/&gt;If the field is true, finAPI stops auto-updates of this bank connection interface to mitigate the risk of locking the user&#39;s bank account and also of triggering a multi-step authentication that might lead to a notification being sent to the end-user.&lt;br/&gt;If the field is false, the user&#39;s attention might still be required for the next bank update, e.g. because of new Terms and Conditions that have to get approved by the user.(this only applies to users whose mandator doesn&#39;t have an AIS license)&lt;br/&gt;Every communication with the bank (e.g. updating a bank connection, submitting a money transfer or a direct debit, etc.) can change the value of this flag. If the field is true, we recommend to ask the end-user to trigger a manual update of the bank connection interface (using the &#39;Update a bank connection&#39; service). If the update completes successfully without triggering a strong customer authentication or results in storing a valid XS2A consent, this flag will switch to false. The logic about determination of the user&#39;s attention being required might change in time. Please use this as a convenience function to know, when you have to involve the user in the next communication with the bank. Once the flag switches to false, the bank connection interface will be enabled again for the auto-update (if it is configured).
     * @DTA\Data(field="userActionRequired")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $user_action_required;

    /**
     * This setting defines how much of an account&#39;s transactions history will be downloaded whenever a new account is imported. More technically, it depicts the number of days to download transactions for, starting from - and including - the date of the account import. For example, on an account import that happens today, the value 30 would instruct finAPI to download transactions from the past 30 days (including today). The minimum allowed value is 14, the maximum value is 3650. Also possible is the value 0 (which is the default value), in which case there will be no limit to the transactions download and finAPI will try to get all transactions that it can. &lt;br/&gt;&lt;br/&gt;Note:&lt;br/&gt;&amp;bull; There is no guarantee that finAPI will actually download transactions for the entire defined date range, as there may be limitations to the download range (set by the bank or by finAPI, e.g. see ClientConfiguration.transactionImportLimitation). &lt;br/&gt;&amp;bull; This parameter only applies to transactions, not to security positions; For security accounts, finAPI will always download all security positions that it can. &lt;br/&gt;&amp;bull; This setting is stored for each interface individually.&lt;br/&gt;&amp;bull; After an interface has been connected with this setting, there is no way to change the setting for that interface afterwards.&lt;br/&gt;&amp;bull; &lt;b&gt;If you do not limit the download range to a value less than 90 days, the bank is more likely to trigger a strong customer authentication request for the user when finAPI is attempting to download the transactions.&lt;/b&gt;
     * @DTA\Data(field="maxDaysForDownload")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $max_days_for_download;

}
