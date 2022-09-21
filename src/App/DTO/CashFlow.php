<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Cash flow
 */
class CashFlow
{
    /**
     * @DTA\Data(field="category")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\CashFlowCategory::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\CashFlowCategory::class})
     * @var \App\DTO\CashFlowCategory|null
     */
    public $category;

    /**
     * The total calculated income for the given category
     * @DTA\Data(field="income")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $income;

    /**
     * The total calculated spending for the given category
     * @DTA\Data(field="spending")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $spending;

    /**
     * The calculated balance for the given category
     * @DTA\Data(field="balance")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $balance;

    /**
     * The total count of income transactions for the given category
     * @DTA\Data(field="countIncomeTransactions")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $count_income_transactions;

    /**
     * The total count of spending transactions for the given category
     * @DTA\Data(field="countSpendingTransactions")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $count_spending_transactions;

    /**
     * The total count of all transactions for the given category
     * @DTA\Data(field="countAllTransactions")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $count_all_transactions;

}
