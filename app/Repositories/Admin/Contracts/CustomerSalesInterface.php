<?php
namespace App\Repositories\Admin\Contracts;


interface CustomerSalesInterface
{
    public function getPageData($param,$perPage);
    public function getPageDataForFinance($param,$perPage);
}
