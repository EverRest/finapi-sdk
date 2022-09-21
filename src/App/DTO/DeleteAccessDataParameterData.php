<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for deleteAccessData
 */
class DeleteAccessDataParameterData
{
    /**
     * Some HTTP clients do not support the HTTP methods PATCH or DELETE. If you are using such a client in your application, you can use a POST request instead with this header indicating the originally intended HTTP method. POST Requests having this  header set will be treated either as PATCH or DELETE by the finAPI servers.
     * @DTA\Data(subset="header", field="X-HTTP-Method-Override", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $x_http_method_override;

    /**
     * The user&#39;s device and/or operating system identification. This header will be forwarded to the bank if the &#39;XS2A&#39; interface is used.
     * @DTA\Data(subset="header", field="PSU-Device-OS", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $psu_device_os;

    /**
     * With any API call, you can pass a request ID. The request ID can be an arbitrary string with up to 255 characters. Passing a longer string will result in an error. If you don&#39;t pass a request ID for a call, finAPI will generate a random ID internally. The request ID is always returned back in the response of a service, as a header with name &#39;X-Request-Id&#39;. We highly recommend to always pass a (preferably unique) request ID, and include it into your client application logs whenever you make a request or receive a response (especially in the case of an error response). finAPI is also logging request IDs on its end. Having a request ID can help the finAPI support team to work more efficiently and solve tickets faster.
     * @DTA\Data(subset="header", field="X-Request-Id", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $x_request_id;

    /**
     * Whether the consent should get deleted from the finAPI database in any case, even if it couldn&#39;t get deleted on the bank’s side. Default value is &#39;false&#39;
     * @DTA\Data(subset="query", field="forceDeletion", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $force_deletion;

    /**
     * Identifier of a bank connection
     * @DTA\Data(subset="path", field="id")
     * @DTA\Strategy(subset="path", name="QueryStringScalar", options={"type":"int"})
     * @DTA\Validator(subset="path", name="QueryStringScalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * The IP address of the user&#39;s device. This header will be forwarded to the bank if the &#39;XS2A&#39; interface is used.
     * @DTA\Data(subset="header", field="PSU-IP-Address", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $psu_ip_address;

    /**
     * The user&#39;s web browser or other client device identification. This header will be forwarded to the bank if the &#39;XS2A&#39; interface is used.
     * @DTA\Data(subset="header", field="PSU-User-Agent", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $psu_user_agent;

    /**
     * Target banking interface
     * @DTA\Data(subset="query", field="interface")
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $interface;

}
