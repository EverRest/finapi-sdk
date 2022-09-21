<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * A container for editing TPP client credentials data
 */
class EditTppCredentialParams
{
    /**
     * The TPP Authentication Group Id for which the credentials can be used
     * @DTA\Data(field="tppAuthenticationGroupId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $tpp_authentication_group_id;

    /**
     * Label for credentials
     * @DTA\Data(field="label", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $label;

    /**
     * ID of the TPP accessing the ASPSP API, as provided by the ASPSP as the result of registration
     * @DTA\Data(field="tppClientId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $tpp_client_id;

    /**
     * Secret of the TPP accessing the ASPSP API, as provided by the ASPSP as the result of registration
     * @DTA\Data(field="tppClientSecret", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $tpp_client_secret;

    /**
     * API Key provided by ASPSP  as the result of registration
     * @DTA\Data(field="tppApiKey", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $tpp_api_key;

    /**
     * TPP name
     * @DTA\Data(field="tppName", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $tpp_name;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Credentials \&quot;valid from\&quot; date. Default is today&#39;s date
     * @DTA\Data(field="validFromDate", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $valid_from_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Credentials \&quot;valid until\&quot; date. Default is null which means \&quot;indefinite\&quot; (no limit)
     * @DTA\Data(field="validUntilDate", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $valid_until_date;

}
