<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * &lt;strong&gt;Type:&lt;/strong&gt; BankConsent&lt;br/&gt; If this field is set, it means that this interface is handing out a consent to finAPI in exchange for the login credentials. finAPI needs to use this consent to get access to the account list and account data (i.e. Account Information Services, AIS). If this field is not set, it means that this interface does not use such consents.
 */
class BankConnectionInterfaceAisConsent
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankConsentStatus&lt;br/&gt; Status of the consent. If &lt;code&gt;PRESENT&lt;/code&gt;, it means that finAPI has a consent stored and can use it to connect to the bank. If &lt;code&gt;NOT_PRESENT&lt;/code&gt;, finAPI will need to acquire a consent when connecting to the bank, which may require login credentials (either passed by the client, or stored in finAPI), and/or user involvement. Note that even when a consent is &lt;code&gt;PRESENT&lt;/code&gt;, it may no longer be valid and finAPI will still have to acquire a new consent.
     * @DTA\Data(field="status")
     * @DTA\Strategy(name="Object", options={"type":BankConsentStatus::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":BankConsentStatus::class})
     * @var BankConsentStatus|null
     */
    public $status;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Expiration time of the consent.
     * @DTA\Data(field="expiresAt")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $expires_at;

}
