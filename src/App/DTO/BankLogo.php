<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * &lt;strong&gt;Type:&lt;/strong&gt; BankImage&lt;br/&gt; Logo of the bank. If available, the logo will be rendered on our Web Form 2.0 where applicable. Customers that do not use our Web Form can use this data to render the bank&#39;s logo within their application&#39;s front end.
 */
class BankLogo
{
    /**
     * The URL to the bank&#39;s image resource.
     * @DTA\Data(field="url")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $url;

}
