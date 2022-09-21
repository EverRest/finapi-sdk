<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Interface used to connect to a bank
 */
class BankInterface
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankingInterface&lt;br/&gt; Bank interface. Possible values:&lt;br&gt;&lt;br&gt;&amp;bull; &lt;code&gt;WEB_SCRAPER&lt;/code&gt; - means that finAPI will parse data from the bank&#39;s online banking website.&lt;br&gt;&amp;bull; &lt;code&gt;FINTS_SERVER&lt;/code&gt; - means that finAPI will download data via the bank&#39;s FinTS server.&lt;br&gt;&amp;bull; &lt;code&gt;XS2A&lt;/code&gt; - means that finAPI will download data via the bank&#39;s XS2A interface.&lt;br&gt;
     * @DTA\Data(field="interface")
     * @DTA\Strategy(name="Object", options={"type":BankingInterface::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":BankingInterface::class})
     * @var BankingInterface|null
     */
    public $interface;

    /**
     * @DTA\Data(field="tppAuthenticationGroup")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\BankInterfaceTppAuthenticationGroup::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\BankInterfaceTppAuthenticationGroup::class})
     * @var \App\DTO\BankInterfaceTppAuthenticationGroup|null
     */
    public $tpp_authentication_group;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankInterfaceLoginField&lt;br/&gt; Login fields for this interface (in the order that we suggest to show them to the user)
     * @DTA\Data(field="loginCredentials")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection508::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection508::class})
     * @var \App\DTO\Collection508|null
     */
    public $login_credentials;

    /**
     * @DTA\Data(field="properties")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection509::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection509::class})
     * @var \App\DTO\Collection509|null
     */
    public $properties;

    /**
     * Login hint. Contains a German message for the user that explains what kind of credentials are expected.&lt;br/&gt;&lt;br/&gt;Please note that it is essential to always show the login hint to the user if there is one, as the credentials that finAPI requires for the bank might be different to the credentials that the user knows from his online banking.&lt;br/&gt;&lt;br/&gt;Also note that the contents of this field should always be interpreted as HTML, as the text might contain HTML tags for highlighted words, paragraphs, etc.
     * @DTA\Data(field="loginHint")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $login_hint;

    /**
     * The health status of this interface. This is a value between 0 and 100, depicting the percentage of successful communication attempts with the bank via this interface during the latest couple of bank connection imports or updates (across the entire finAPI system). Note that &#39;successful&#39; means that there was no technical error trying to establish a communication with the bank. Non-technical errors (like incorrect credentials) are regarded successful communication attempts.
     * @DTA\Data(field="health")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @DTA\Validator(name="GreaterThan", options={"min":0, "inclusive":true})
     * @DTA\Validator(name="LessThan", options={"max":100, "inclusive":true})
     * @var int|null
     */
    public $health;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Time of the last communication attempt with this interface during an import, update or connect interface (across the entire finAPI system).
     * @DTA\Data(field="lastCommunicationAttempt")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $last_communication_attempt;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Time of the last successful communication with this interface during an import, update or connect interface (across the entire finAPI system).
     * @DTA\Data(field="lastSuccessfulCommunication")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $last_successful_communication;

    /**
     * Whether this interface has the general capability to perform Account Information Services (AIS), i.e. if this interface can be used to download accounts, balances and transactions.
     * @DTA\Data(field="isAisSupported")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_ais_supported;

    /**
     * @DTA\Data(field="paymentCapabilities")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\BankInterfacePaymentCapabilities::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\BankInterfacePaymentCapabilities::class})
     * @var \App\DTO\BankInterfacePaymentCapabilities|null
     */
    public $payment_capabilities;

    /**
     * @DTA\Data(field="aisAccountTypes")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection510::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection510::class})
     * @var \App\DTO\Collection510|null
     */
    public $ais_account_types;

}
