<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a Web Form&#39;s data
 */
class WebForm
{
    /**
     * Web Form identifier, as returned in the 451 response of the REST service call that initiated the Web Form flow.
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Token for the finAPI Web Form page, as contained in the 451 response of the REST service call that initiated the Web Form flow (in the &#39;Location&#39; header).
     * @DTA\Data(field="token")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $token;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; WebFormStatus&lt;br/&gt; Status of a Web Form. Possible values are:&lt;br/&gt;&amp;bull; NOT_YET_OPENED - the Web Form URL was not yet called;&lt;br/&gt;&amp;bull; IN_PROGRESS - the Web Form has been opened but not yet submitted by the user;&lt;br/&gt;&amp;bull; COMPLETED - the user has opened and submitted the Web Form;&lt;br/&gt;&amp;bull; ABORTED - the user has opened but then aborted the Web Form, or the Web Form was aborted by the finAPI system because it has expired (this is the case when a Web Form is opened and then not submitted within 10 minutes)
     * @DTA\Data(field="status")
     * @DTA\Strategy(name="Object", options={"type":WebFormStatus::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":WebFormStatus::class})
     * @var WebFormStatus|null
     */
    public $status;

    /**
     * HTTP response code of the REST service call that initiated the Web Form flow. This field can be queried as soon as the status becomes COMPLETED or ABORTED. Note that it is still not guaranteed in this case that the field has a value, i.e. it might be null.
     * @DTA\Data(field="serviceResponseCode", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $service_response_code;

    /**
     * HTTP response body of the REST service call that initiated the Web Form flow. This field can be queried as soon as the status becomes COMPLETED or ABORTED. Note that it is still not guaranteed in this case that the field has a value, i.e. it might be null.
     * @DTA\Data(field="serviceResponseBody", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $service_response_body;

}
