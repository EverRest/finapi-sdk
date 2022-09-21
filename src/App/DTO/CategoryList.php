<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for data of multiple categories
 */
class CategoryList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Category&lt;br/&gt; Categories
     * @DTA\Data(field="categories")
     * @DTA\Strategy(name="Object", options={"type":::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":::class})
     * @var \App\DTO\Category[]|null
     */
    public $categories;

}
