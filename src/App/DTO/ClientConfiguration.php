<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Client configuration parameters
 */
class ClientConfiguration
{
    /**
     * Whether your client is allowed to call PFM services (Personal Finance Management). The set of PFM services is the following:&lt;br/&gt;&lt;br/&gt;&amp;bull; all /mandatorAdmin/ibanRules/_* and /mandatorAdmin/keywordRules/_* services&lt;br/&gt;&amp;bull; GET /accounts/dailyBalances&lt;br/&gt;&amp;bull; all /transactions/_* services, except for GET /transactions/[id(s)] and DELETE /transactions/[id]&lt;br/&gt;&amp;bull; all /categories/_* services, except for GET /categories/[id(s)]&lt;br/&gt;&amp;bull; all /labels/_* services&lt;br/&gt;&amp;bull; all /notificationRules/_* services&lt;br/&gt;&amp;bull; all /tests/_* services
     * @DTA\Data(field="pfmServicesEnabled")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $pfm_services_enabled;

    /**
     * Whether finAPI performs a regular automatic update of your users&#39; bank connections. To find out how the automatic batch update is configured for your client, i.e. which bank connections get updated, and at which time and interval, please contact your Sys-Admin. Note that even if the automatic batch update is enabled for your client, individual users can still disable the feature for their own bank connections.
     * @DTA\Data(field="isAutomaticBatchUpdateEnabled")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_automatic_batch_update_enabled;

    /**
     * Whether development mode is enabled. This setting is enabled on mandator level and allows any user to access the &#39;Mock batch update&#39; service. &lt;br/&gt;&lt;br/&gt;NOTE: This flag is meant for testing purposes during development of your application. &lt;br/&gt;This is why this will never be enabled on a production environment.
     * @DTA\Data(field="isDevelopmentModeEnabled")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_development_mode_enabled;

    /**
     * Whether finAPI will download data (balance and transactions) for bank accounts with a currency other than EUR (affects all users). If this flag is false, then non-EUR accounts will still be returned in the account list, but they will have no balance and no transactions. Note that this currently applies to Checking accounts only.
     * @DTA\Data(field="isNonEuroAccountsSupported")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_non_euro_accounts_supported;

    /**
     * Whether transactions will be categorized as soon as they are downloaded. &lt;br/&gt;In case this flag is false, the user needs to manually trigger categorization using the &#39;Trigger categorization&#39; service.
     * @DTA\Data(field="isAutoCategorizationEnabled")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_auto_categorization_enabled;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; MandatorLicense&lt;br/&gt; The license associated with your client. &lt;br/&gt;The licensing model affects the TPP registration data used to connect to the bank (e.g. &lt;b&gt;finTSProductRegistrationNumber&lt;/b&gt; for FINTS_SERVER interface). Licenses are administered by finAPI. Please contact the support to change the license that was set up for you.&lt;br/&gt;Possible values are:&lt;br/&gt;UNLICENSED: finAPI will use its own TPP registration to connect to the bank for both account information services (AIS) and payment initiation services (PIS).&lt;br/&gt;AISP: finAPI will use its own TPP registration to connect to the bank for PIS, and your registration for AIS.&lt;br/&gt;PISP: finAPI will use its own TPP registration to connect to the bank for AIS, and your registration for PIS.&lt;br/&gt;FULLY_LICENSED: finAPI will use your TPP registration to connect to the bank for both AIS and PIS.
     * @DTA\Data(field="mandatorLicense")
     * @DTA\Strategy(name="Object", options={"type":MandatorLicense::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":MandatorLicense::class})
     * @var MandatorLicense|null
     */
    public $mandator_license;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; PreferredConsentType&lt;br/&gt; The preferred consent type that will be used for the XS2A interface.&lt;br/&gt;&lt;br/&gt;&lt;b&gt;ONETIME&lt;/b&gt; - The consent can only be used once to download data associated with the account. The consent won’t be saved by finAPI.&lt;br/&gt;&lt;b&gt;RECURRING&lt;/b&gt; - The consent is valid for up to 90 days and can be used by finAPI to access and download account data for up to 4 times per day.&lt;br/&gt;&lt;br/&gt;NOTE: If the bank does not support the preferred consent type, then finAPI will default to the other type.
     * @DTA\Data(field="preferredConsentType")
     * @DTA\Strategy(name="Object", options={"type":PreferredConsentType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":PreferredConsentType::class})
     * @var PreferredConsentType|null
     */
    public $preferred_consent_type;

    /**
     * Callback URL to which finAPI sends the notification messages that are triggered from the automatic batch update of the users&#39; bank connections. This field is only relevant if the automatic batch update is enabled for your client. For details about what the notification messages look like, please see the documentation in the &#39;Notification Rules&#39; section. finAPI will call this URL with HTTP method POST. Note that the response of the call is not processed by finAPI. Also note that while the callback URL may be a non-secured (http) URL on the finAPI sandbox or alpha environment, it MUST be a SSL-secured (https) URL on the finAPI live system.
     * @DTA\Data(field="userNotificationCallbackUrl")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $user_notification_callback_url;

    /**
     * Callback URL for user synchronization. This field should be set if you - as a finAPI customer - have multiple clients using finAPI. In such case, all of your clients will share the same user base, making it possible for a user to be created in one client, but then deleted in another. To keep the client-side user data consistent in all clients, you should set a callback URL for each client. finAPI will send a notification to the callback URL of each client whenever a user of your user base gets deleted. Note that finAPI will send a deletion notification to ALL clients, including the one that made the user deletion request to finAPI. So when deleting a user in finAPI, a client should rely on the callback to delete the user on its own side. &lt;p&gt;The notification that finAPI sends to the clients&#39; callback URLs will be a POST request, with this body: &lt;pre&gt;{    \&quot;userId\&quot; : string // contains the identifier of the deleted user    \&quot;event\&quot; : string // this will always be \&quot;DELETED\&quot; }&lt;/pre&gt;&lt;br/&gt;Note that finAPI does not process the response of this call. Also note that while the callback URL may be a non-secured (http) URL on the finAPI sandbox or alpha environment, it MUST be a SSL-secured (https) URL on the finAPI live system.&lt;/p&gt;As long as you have just one client, you can ignore this field and let it be null. However keep in mind that in this case your client will not receive any callback when a user gets deleted - so the deletion of the user on the client-side must not be forgotten. Of course you may still use the callback URL even for just one client, if you want to implement the deletion of the user on the client-side via the callback from finAPI.
     * @DTA\Data(field="userSynchronizationCallbackUrl")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $user_synchronization_callback_url;

    /**
     * The validity period that newly requested refresh tokens initially have (in seconds). A value of 0 means that the tokens never expire (Unless explicitly invalidated, e.g. by revocation, or when a user gets locked, or when the password is reset for a user).
     * @DTA\Data(field="refreshTokensValidityPeriod")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $refresh_tokens_validity_period;

    /**
     * The validity period that newly requested access tokens for users initially have (in seconds). A value of 0 means that the tokens never expire (Unless explicitly invalidated, e.g. by revocation, or when a user gets locked, or when the password is reset for a user).
     * @DTA\Data(field="userAccessTokensValidityPeriod")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $user_access_tokens_validity_period;

    /**
     * The validity period that newly requested access tokens for clients initially have (in seconds). A value of 0 means that the tokens never expire (Unless explicitly invalidated, e.g. by revocation).
     * @DTA\Data(field="clientAccessTokensValidityPeriod")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $client_access_tokens_validity_period;

    /**
     * Number of consecutive failed login attempts of a user into his finAPI account that is allowed before finAPI locks the user&#39;s account. When a user&#39;s account is locked, finAPI will invalidate all user&#39;s tokens and it will deny any service call in the context of this user (i.e. any call to a service using one of the user&#39;s authorization tokens, as well as the service for requesting a new token for this user). To unlock a user&#39;s account, a new password must be set for the account by the client (see the services /users/requestPasswordChange and /users/executePasswordChange). Once a new password has been set, all services will be available again for this user and the user&#39;s failed login attempts counter is reset to 0. The user&#39;s failed login attempts counter is also reset whenever a new authorization token has been successfully retrieved, or whenever the user himself changes his password.&lt;br/&gt;&lt;br/&gt;Note that when this field has a value of 0, it means that there is no limit for user login attempts, i.e. finAPI will never lock user accounts.
     * @DTA\Data(field="maxUserLoginAttempts")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $max_user_login_attempts;

    /**
     * This setting defines the upper limit of how much of an account&#39;s transactions history may be downloaded whenever a new account is imported, across all of your users. More technically, it depicts the maximum number of days for which transactions might get downloaded, starting from - and including - the date of the account import. &#39;0&#39; means that there is no limitation.
     * @DTA\Data(field="transactionImportLimitation")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $transaction_import_limitation;

    /**
     * Whether users that are created with this client are automatically verified on creation. If this field is set to &#39;false&#39;, then any user that is created with this client must first be verified with the \&quot;Verify a user\&quot; service before he can be authorized. If the field is &#39;true&#39;, then no verification is required by the client and the user can be authorized immediately after creation.
     * @DTA\Data(field="isUserAutoVerificationEnabled")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_user_auto_verification_enabled;

    /**
     * Whether this client is a &#39;Mandator Admin&#39;. Mandator Admins are special clients that can access the &#39;Mandator Administration&#39; section of finAPI. If you do not yet have credentials for a Mandator Admin, please contact us at support@finapi.io. For further information, please refer to &lt;a href&#x3D;&#39;https://documentation.finapi.io/access/Application-management.2763423767.html&#39; target&#x3D;&#39;_blank&#39;&gt;this page&lt;/a&gt; on our Access Public Documentation.
     * @DTA\Data(field="isMandatorAdmin")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_mandator_admin;

    /**
     * Whether finAPI is allowed to use the WEB_SCRAPER interface for data download or payments. &lt;br/&gt;&lt;br/&gt;If this field is set to &#39;true&#39;, then finAPI might download data from the online banking websites of banks (either in addition to other interfaces, or as the sole data source for the download). Also, it will be possible to do payments via the WEB_SCRAPER interface.&lt;br/&gt;&lt;br/&gt;If this field is set to &#39;false&#39;, then finAPI will not use any web scrapers. Payments via the WEB_SCRAPER interface will not be possible, and finAPI will not allow any data download for banks where no other interface except WEB_SCRAPER is available. &lt;br/&gt;&lt;br/&gt;Please contact your Sys-Admin if you want to change this setting.
     * @DTA\Data(field="isWebScrapingEnabled")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_web_scraping_enabled;

    /**
     * Whether this client is allowed to do PIS.&lt;br/&gt;&lt;br/&gt;Note that on the Sandbox environment, it is always possible to execute payments (regardless of what this field says), as long as you are using a test bank (see Bank.isTestBank)
     * @DTA\Data(field="paymentsEnabled")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $payments_enabled;

    /**
     * Whether this client is allowed to do standalone PIS (doing money transfers and standing orders for accounts that are not imported in finAPI).&lt;br/&gt;&lt;br/&gt;Note that on the Sandbox environment, it is always possible to execute payments and standing orders (regardless of what this field says), as long as you are using a test bank (see Bank.isTestBank)
     * @DTA\Data(field="isStandalonePaymentsEnabled")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_standalone_payments_enabled;

    /**
     * @DTA\Data(field="availableBankGroups")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection364::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection364::class})
     * @var \App\DTO\Collection364|null
     */
    public $available_bank_groups;

    /**
     * @DTA\Data(field="products")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection365::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection365::class})
     * @var \App\DTO\Collection365|null
     */
    public $products;

    /**
     * The FinTS product registration number. If a value is stored, this will always be &#39;XXXXX&#39;.
     * @DTA\Data(field="finTSProductRegistrationNumber")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $fin_ts_product_registration_number;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; WebFormMode&lt;br/&gt; Indicates whether the client is using the finAPI Web Form for Account Information Services.&lt;br/&gt;&lt;br/&gt;Possible values: &lt;br/&gt;&amp;bull; &lt;code&gt;DISABLED&lt;/code&gt; - No Web Form is triggered&lt;br/&gt;&amp;bull; &lt;code&gt;INTERNAL&lt;/code&gt; - THIS VALUE IS DEPRECATED AND WILL BE REMOVED. Hence, we request customers to foresee a migration to Web Form 2.0 (value &lt;code&gt;EXTERNAL&lt;/code&gt;).&lt;br/&gt;End users will be directed to the classical Web Form implementation.&lt;br/&gt;&amp;bull; &lt;code&gt;EXTERNAL&lt;/code&gt; - End users will be directed to the &lt;a href&#x3D;&#39;https://documentation.finapi.io/webform/Introduction.2038136860.html&#39;  target&#x3D;&#39;_blank&#39;&gt;new Web Form&lt;/a&gt; implementation.
     * @DTA\Data(field="aisWebFormMode")
     * @DTA\Strategy(name="Object", options={"type":WebFormMode::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":WebFormMode::class})
     * @var WebFormMode|null
     */
    public $ais_web_form_mode;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; WebFormMode&lt;br/&gt; Indicates whether the client is using the finAPI Web Form for Standard Payment Initiation Services (Payments for accounts that have been imported in finAPI).&lt;br/&gt;&lt;br/&gt;Possible values: &lt;br/&gt;&amp;bull; &lt;code&gt;DISABLED&lt;/code&gt; - No Web Form is triggered&lt;br/&gt;&amp;bull; &lt;code&gt;INTERNAL&lt;/code&gt; - THIS VALUE IS DEPRECATED AND WILL BE REMOVED. Hence, we request customers to foresee a migration to Web Form 2.0 (value &lt;code&gt;EXTERNAL&lt;/code&gt;).&lt;br/&gt;End users will be directed to the classical Web Form implementation.&lt;br/&gt;&amp;bull; &lt;code&gt;EXTERNAL&lt;/code&gt; - End users will be directed to the &lt;a href&#x3D;&#39;https://documentation.finapi.io/webform/Introduction.2038136860.html&#39;  target&#x3D;&#39;_blank&#39;&gt;new Web Form&lt;/a&gt; implementation.
     * @DTA\Data(field="pisWebFormMode")
     * @DTA\Strategy(name="Object", options={"type":WebFormMode::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":WebFormMode::class})
     * @var WebFormMode|null
     */
    public $pis_web_form_mode;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; WebFormMode&lt;br/&gt; Indicates whether the client is using the finAPI Web Form for Standalone Payment Initiation Services (Payments without account import).&lt;br/&gt;&lt;br/&gt;Possible values: &lt;br/&gt;&amp;bull; &lt;code&gt;DISABLED&lt;/code&gt; - No Web Form is triggered&lt;br/&gt;&amp;bull; &lt;code&gt;INTERNAL&lt;/code&gt; - THIS VALUE IS DEPRECATED AND WILL BE REMOVED. Hence, we request customers to foresee a migration to Web Form 2.0 (value &lt;code&gt;EXTERNAL&lt;/code&gt;).&lt;br/&gt;End users will be directed to the classical Web Form implementation.&lt;br/&gt;&amp;bull; &lt;code&gt;EXTERNAL&lt;/code&gt; - End users will be directed to the &lt;a href&#x3D;&#39;https://documentation.finapi.io/webform/Introduction.2038136860.html&#39;  target&#x3D;&#39;_blank&#39;&gt;new Web Form&lt;/a&gt; implementation.
     * @DTA\Data(field="pisStandaloneWebFormMode")
     * @DTA\Strategy(name="Object", options={"type":WebFormMode::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":WebFormMode::class})
     * @var WebFormMode|null
     */
    public $pis_standalone_web_form_mode;

    /**
     * Whether the set of banks that are available to your client contains \&quot;Beta banks\&quot;. Beta banks provide pre-release interfaces that are still in a beta phase. Communication to the bank via such interfaces might be unstable, and the correctness and/or quality of data delivery or payment execution cannot be guaranteed.&lt;br/&gt;As the word \&quot;BETA\&quot; already indicates, Beta banks are subject to changes. Their properties, as well as their behaviour can change based on continuous tests and customer feedback. Also, to keep our bank list clean, we might remove Beta banks at any point in time, including all related user data (bank connections, accounts, transactions etc). We still recommend you to enable beta banks in your application, because it enables us to release a stable interface faster. However, you should point it out to your users when using a beta bank (also see field Bank.isBeta).&lt;br/&gt;&lt;br/&gt;If this field is true, then the GET /banks services will include beta banks in their results, and you can use beta banks in any service where you can pass a bank identifier. If the field is false, then beta banks will not exist for your client.
     * @DTA\Data(field="betaBanksEnabled")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $beta_banks_enabled;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Category&lt;br/&gt; Defines the set of transaction categories to which your client is restricted. When retrieving transactions (via the GET /transactions services), you may request only those transactions whose &#39;category&#39; is one of the listed categories. If this field is null, then there are no restrictions for your client, and you may retrieve the full set of imported transactions.
     * @DTA\Data(field="categoryRestrictions")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection367::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection367::class})
     * @var \App\DTO\Collection367|null
     */
    public $category_restrictions;

    /**
     * The list of allowed origins for cross-origin requests. The CORS configuration applies to all the API services except for the /oauth services. If this list is empty, then CORS is not enabled for this client. Please contact the support if you want to enable or change the client&#39;s CORS configuration.
     * @DTA\Data(field="corsAllowedOrigins")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection368::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection368::class})
     * @var \App\DTO\Collection368|null
     */
    public $cors_allowed_origins;

}
