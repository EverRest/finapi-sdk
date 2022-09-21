<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * A container for the bank certificate&#39;s data
 */
class TppCertificate
{
    /**
     * A certificate identifier.
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; TppCertificateType&lt;br/&gt; Type of certificate.
     * @DTA\Data(field="certificateType")
     * @DTA\Strategy(name="Object", options={"type":TppCertificateType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":TppCertificateType::class})
     * @var TppCertificateType|null
     */
    public $certificate_type;

    /**
     * Label of certificate.
     * @DTA\Data(field="label")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $label;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Valid from date.
     * @DTA\Data(field="validFrom")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $valid_from;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Valid until date.
     * @DTA\Data(field="validUntil")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $valid_until;

}
