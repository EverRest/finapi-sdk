<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Standing order submission parameters
 */
class SubmitStandingOrderParams
{
    /**
     * Standing order identifier
     * @DTA\Data(field="standingOrderId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $standing_order_id;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankingInterface&lt;br/&gt; Bank interface. Possible values:&lt;br&gt;&lt;br&gt;&amp;bull; &lt;code&gt;FINTS_SERVER&lt;/code&gt; - means that finAPI will execute the standing order via the bank&#39;s FinTS interface.&lt;br&gt;&amp;bull; &lt;code&gt;WEB_SCRAPER&lt;/code&gt; - means that finAPI will parse data from the bank&#39;s online banking website.&lt;br&gt;&amp;bull; &lt;code&gt;XS2A&lt;/code&gt; - means that finAPI will execute the standing order via the bank&#39;s XS2A interface.&lt;br/&gt;To determine what interface(s) you can choose to submit a standing order, please refer to the field paymentCapabilities.sepaStandingOrder in BankInterface.&lt;br/&gt;For standalone standing orders in particular, we suggest to always use XS2A if supported, and only use FINTS_SERVER or WEB_SCRAPER as a fallback, because non-XS2A interfaces might require not just a single, but multiple authentications when submitting the standing order.&lt;br/&gt;
     * @DTA\Data(field="interface")
     * @DTA\Strategy(name="Object", options={"type":BankingInterface::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":BankingInterface::class})
     * @var BankingInterface|null
     */
    public $interface;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; LoginCredential&lt;br/&gt; Login credentials. May not be required when the credentials are stored in finAPI, or when the bank interface has no login credentials.
     * @DTA\Data(field="loginCredentials", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection100::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection100::class})
     * @var \App\DTO\Collection100|null
     */
    public $login_credentials;

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
