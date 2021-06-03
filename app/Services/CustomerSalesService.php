<?php
/**
 * 产品 Service
 *
 */

namespace App\Services;

use App\Repositories\Admin\Contracts\CustomerSalesInterface;
use App\Traits\Admin\PhpOffice;
use Illuminate\Http\Request;

class CustomerSalesService extends AdminBaseService
{
    use PhpOffice;

    protected $request;
    protected $interface;
    protected $admin_user;

    public function __construct(
        Request $request ,
        CustomerSalesInterface $customerSalesInterface
    )
    {
        $this->request   = $request;
        $this->interface = $customerSalesInterface;
        $this->admin_user  = session(LOGIN_USER);

        if (!$this->request->has(["year","month"])) {
            $this->request->merge([
                "year" => date("Y"),
                "month" => date("n"),
            ]);
        }
    }

    public function getPageData()
    {
        $param = $this->request->input();
        $data  = $this->interface->getPageData($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    public function getPageDataForFinance()
    {
        $param = $this->request->input();
        $data  = $this->interface->getPageDataForFinance($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

}
