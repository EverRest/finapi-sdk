<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Client configuration parameters
 */
class ClientConfigurationParams
{
    /**
     * Callback URL to which finAPI sends the notification messages that are triggered from the automatic batch update of the users&#39; bank connections. This field is only relevant if the automatic batch update is enabled for your client. For details about what the notification messages look like, please see the documentation in the &#39;Notification Rules&#39; section. finAPI will call this URL with HTTP method POST. Note that the response of the call is not processed by finAPI. Also note that while the callback URL may be a non-secured (http) URL on the finAPI sandbox or alpha environment, it MUST be a SSL-secured (https) URL on the finAPI live system.&lt;p&gt;The maximum allowed length of the URL is 512. If you have previously set a callback URL and now want to clear it (thus disabling user-related notifications altogether), you can pass an empty string (\&quot;\&quot;).
     * @DTA\Data(field="userNotificationCallbackUrl", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $user_notification_callback_url;

    /**
     * Callback URL for user synchronization. This field should be set if you - as a finAPI customer - have multiple clients using finAPI. In such case, all of your clients will share the same user base, making it possible for a user to be created in one client, but then deleted in another. To keep the client-side user data consistent in all clients, you should set a callback URL for each client. finAPI will send a notification to the callback URL of each client whenever a user of your user base gets deleted. Note that finAPI will send a deletion notification to ALL clients, including the one that made the user deletion request to finAPI. So when deleting a user in finAPI, a client should rely on the callback to delete the user on its own side. &lt;p&gt;The notification that finAPI sends to the clients&#39; callback URLs will be a POST request, with this body: &lt;pre&gt;{    \&quot;userId\&quot; : string // contains the identifier of the deleted user    \&quot;event\&quot; : string // this will always be \&quot;DELETED\&quot; }&lt;/pre&gt;&lt;br/&gt;Note that finAPI does not process the response of this call. Also note that while the callback URL may be a non-secured (http) URL on the finAPI sandbox or alpha system, it MUST be a SSL-secured (https) URL on the live system.&lt;/p&gt;As long as you have just one client, you can ignore this field and let it be null. However keep in mind that in this case your client will not receive any callback when a user gets deleted - so the deletion of the user on the client-side must not be forgotten. Of course you may still use the callback URL even for just one client, if you want to implement the deletion of the user on the client-side via the callback from finAPI.&lt;p&gt; The maximum allowed length of the URL is 512. If you have previously set a callback URL and now want to clear it (thus disabling user synchronization related notifications for this client), you can pass an empty string (\&quot;\&quot;).
     * @DTA\Data(field="userSynchronizationCallbackUrl", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $user_synchronization_callback_url;

    /**
     * The validity period that newly requested refresh tokens initially have (in seconds). The value must be greater than or equal to 60, or 0. A value of 0 means that the tokens never expire (Unless explicitly invalidated, e.g. by revocation , or when a user gets locked, or when the password is reset for a user).
     * @DTA\Data(field="refreshTokensValidityPeriod", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $refresh_tokens_validity_period;

    /**
     * The validity period that newly requested access tokens for users initially have (in seconds). The value must be greater than or equal to 60, or 0. A value of 0 means that the tokens never expire.
     * @DTA\Data(field="userAccessTokensValidityPeriod", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $user_access_tokens_validity_period;

    /**
     * The validity period that newly requested access tokens for clients initially have (in seconds). The value must be greater than or equal to 60, or 0. A value of 0 means that the tokens never expire.
     * @DTA\Data(field="clientAccessTokensValidityPeriod", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $client_access_tokens_validity_period;

    /**
     * The FinTS product registration number. Please follow &lt;a href&#x3D;&#39;https://www.hbci-zka.de/register/prod_register.htm&#39; target&#x3D;&#39;_blank&#39;&gt;this link&lt;/a&gt; to apply for a registration number. Only customers who have an AISP or PISP license must define their FinTS product registration number. Customers who are relying on the finAPI Web Form will be assigned to finAPI&#39;s FinTS product registration number automatically and do not have to register themselves. During a batch update, finAPI is using the FinTS product registration number of the client, that was used to create the user. If you have previously set a FinTS product registration number and now want to clear it, you can pass an empty string (\&quot;\&quot;). Only hexa decimal characters in capital case with a maximum length of 25 characters are allowed. E.g. &#39;ABCDEF1234567890ABCDEF123&#39;
     * @DTA\Data(field="finTSProductRegistrationNumber", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[0-9A-F]*/"})
     * @var string|null
     */
    public $fin_ts_product_registration_number;

    /**
     * Whether the set of banks that are available to your client should include \&quot;Beta banks\&quot;. Beta banks provide pre-release interfaces that are still in a beta phase. Communication to the bank via such interfaces might be unstable, and the correctness and/or quality of data delivery or payment execution cannot be guaranteed.&lt;br/&gt;As the word \&quot;BETA\&quot; already indicates, Beta banks are subject to changes. Their properties, as well as their behaviour can change based on continuous tests and customer feedback. Also, to keep our bank list clean, we might remove Beta banks at any point in time, including all related user data (bank connections, accounts, transactions etc). We still recommend you to enable beta banks in your application, because it enables us to release a stable interface faster. However, you should point it out to your users when using a beta bank (also see field Bank.isBeta).&lt;br/&gt;&lt;br/&gt;If this field is true, then the GET /banks services will include beta banks in their results, and you can use beta banks in any service where you can pass a bank identifier. If the field is false, then beta banks will not exist for your client.
     * @DTA\Data(field="betaBanksEnabled", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $beta_banks_enabled;

}
