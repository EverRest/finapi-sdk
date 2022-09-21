<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * A container for the new certificate data
 */
class TppCertificateParams
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; TppCertificateType&lt;br/&gt; The type of the submitted certificate
     * @DTA\Data(field="type")
     * @DTA\Strategy(name="Object", options={"type":TppCertificateType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":TppCertificateType::class})
     * @var TppCertificateType|null
     */
    public $type;

    /**
     * A certificate (public key)
     * @DTA\Data(field="publicKey")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $public_key;

    /**
     * A private key in PKCS #8 or PKCS #1 format. PKCS #1/#8 private keys are typically exchanged in the PEM base64-encoded format (https://support.quovadisglobal.com/kb/a37/what-is-pem-format.aspx)&lt;br/&gt;&lt;br/&gt;NOTE: The certificate should have one of the following headers:&lt;br/&gt;- &#39;-----BEGIN RSA PRIVATE KEY-----&#39;&lt;br/&gt;- &#39;-----BEGIN PRIVATE KEY-----&#39;&lt;br/&gt;- &#39;-----BEGIN ENCRYPTED PRIVATE KEY-----&#39;&lt;br/&gt;Any other header denotes that the private key is neither in PKCS #8 nor in PKCS #1 formats!&lt;br/&gt;&lt;br/&gt;Also, bear in mind that if the private key is in PKCS #1 encrypted format, the encryption information must be provided with explicitly separated lines (the JSON must contain \&quot;\\n\&quot; at the end of each line), such as in the example below:&lt;br/&gt;-----BEGIN RSA PRIVATE KEY-----&lt;br/&gt;Proc-Type: 4,ENCRYPTED&lt;br/&gt;DEK-Info: AES-256-CBC,BFA11F426E7D634BC621C77A72B804DB&lt;br/&gt;...&lt;br/&gt;-----END RSA PRIVATE KEY-----
     * @DTA\Data(field="privateKey")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $private_key;

    /**
     * Optional passphrase for the private key
     * @DTA\Data(field="passphrase", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $passphrase;

    /**
     * A certificate (public key) of the certificate authority (CA) that signed the certificate. Required in certain cases to build the PKI path between Access and the bank&#39;s API when banks do not possess intermediate TLS certificates while placing the trust chain.
     * @DTA\Data(field="caPublicKey", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $ca_public_key;

    /**
     * A label for the certificate
     * @DTA\Data(field="label")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $label;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Start day of the certificate&#39;s validity. Default is the passed certificate validFrom date
     * @DTA\Data(field="validFromDate", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $valid_from_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Expiration day of the certificate&#39;s validity. Default is the passed certificate validUntil date
     * @DTA\Data(field="validUntilDate", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $valid_until_date;

}
