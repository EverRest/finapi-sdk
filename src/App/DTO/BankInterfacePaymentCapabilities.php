<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * &lt;strong&gt;Type:&lt;/strong&gt; BankInterfacePaymentCapabilities&lt;br/&gt; The general payment capabilities of this interface. If a capability is &#39;true&#39;, it means that the option is supported, as long as the involved account also supports it (see AccountInterface.capabilities and AccountInterface.paymentCapabilities). Note that the &#39;sepaFutureDatedMoneyTransfer&#39; capability is not defined on account interface level - this is because this capability is account-independent. If this capability is &#39;true&#39;, then all accounts of this interface will support it, as long as they support money transfers in general. &lt;br/&gt;&lt;br/&gt;If a capability is &#39;false&#39;, then the option is not supported for any account.
 */
class BankInterfacePaymentCapabilities
{
    /**
     * Capability to do SEPA direct debits.
     * @DTA\Data(field="sepaDirectDebit")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $sepa_direct_debit;

    /**
     * Capability to do a (single) SEPA money transfer.
     * @DTA\Data(field="sepaMoneyTransfer")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $sepa_money_transfer;

    /**
     * Capability to do a (single) SEPA instant money transfer.
     * @DTA\Data(field="sepaInstantMoneyTransfer")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $sepa_instant_money_transfer;

    /**
     * Capability to do a collective SEPA money transfer.
     * @DTA\Data(field="sepaCollectiveMoneyTransfer")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $sepa_collective_money_transfer;

    /**
     * Capability to do SEPA money transfers with a future execution date.
     * @DTA\Data(field="sepaFutureDatedMoneyTransfer")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $sepa_future_dated_money_transfer;

    /**
     * Capability to do a SEPA standing order.
     * @DTA\Data(field="sepaStandingOrder")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $sepa_standing_order;

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

    /**
     * Capability to do a domestic money transfer with a future execution date.
     * @DTA\Data(field="domesticFutureDatedMoneyTransfer")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $domestic_future_dated_money_transfer;

}
