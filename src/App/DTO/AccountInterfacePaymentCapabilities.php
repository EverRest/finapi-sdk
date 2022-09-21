<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * &lt;strong&gt;Type:&lt;/strong&gt; AccountInterfacePaymentCapabilities&lt;br/&gt; The payment capabilities of this account.
 */
class AccountInterfacePaymentCapabilities
{
    /**
     * Capability to do a (single) SEPA instant money transfer.
     * @DTA\Data(field="sepaInstantMoneyTransfer")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $sepa_instant_money_transfer;

    /**
     * Capability to do a domestic money transfer.
     * @DTA\Data(field="domesticMoneyTransfer")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $domestic_money_transfer;

    /**
     * Capability to do a collective domestic money transfer.
     * @DTA\Data(field="domesticCollectiveMoneyTransfer")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $domestic_collective_money_transfer;

}
