<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * A container for the TPP client credentials data
 */
class TppCredentials
{
    /**
     * The credential identifier.
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Label of tpp client credentials set.
     * @DTA\Data(field="label")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $label;

    /**
     * TPP Authentication Group ID.
     * @DTA\Data(field="tppAuthenticationGroupId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $tpp_authentication_group_id;

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
