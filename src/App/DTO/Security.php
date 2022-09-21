<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a security position&#39;s data
 */
class Security
{
    /**
     * Identifier. Note: Whenever a security account is being updated, its security positions will be internally re-created, meaning that the identifier of a security position might change over time.
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Security account identifier
     * @DTA\Data(field="accountId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $account_id;

    /**
     * Name
     * @DTA\Data(field="name")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $name;

    /**
     * ISIN
     * @DTA\Data(field="isin")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $isin;

    /**
     * WKN
     * @DTA\Data(field="wkn")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $wkn;

    /**
     * Quote
     * @DTA\Data(field="quote")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $quote;

    /**
     * Currency of quote
     * @DTA\Data(field="quoteCurrency")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $quote_currency;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; SecurityPositionQuoteType&lt;br/&gt; Type of quote. &#39;PERC&#39; if quote is a percentage value, &#39;ACTU&#39; if quote is the actual amount
     * @DTA\Data(field="quoteType")
     * @DTA\Strategy(name="Object", options={"type":SecurityPositionQuoteType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":SecurityPositionQuoteType::class})
     * @var SecurityPositionQuoteType|null
     */
    public $quote_type;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Quote date.
     * @DTA\Data(field="quoteDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $quote_date;

    /**
     * Value of quantity or nominal
     * @DTA\Data(field="quantityNominal")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $quantity_nominal;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; SecurityPositionQuantityNominalType&lt;br/&gt; Type of quantity or nominal value. &#39;UNIT&#39; if value is a quantity, &#39;FAMT&#39; if value is the nominal amount
     * @DTA\Data(field="quantityNominalType")
     * @DTA\Strategy(name="Object", options={"type":SecurityPositionQuantityNominalType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":SecurityPositionQuantityNominalType::class})
     * @var SecurityPositionQuantityNominalType|null
     */
    public $quantity_nominal_type;

    /**
     * Market value
     * @DTA\Data(field="marketValue")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $market_value;

    /**
     * Currency of market value
     * @DTA\Data(field="marketValueCurrency")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $market_value_currency;

    /**
     * Entry quote
     * @DTA\Data(field="entryQuote")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $entry_quote;

    /**
     * Currency of entry quote
     * @DTA\Data(field="entryQuoteCurrency")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $entry_quote_currency;

    /**
     * Current profit or loss
     * @DTA\Data(field="profitOrLoss")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $profit_or_loss;

}
