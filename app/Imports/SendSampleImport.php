<?php

namespace App\Imports;

use App\Http\Model\Common\Product;
use App\Http\Model\Common\SendSample;
use App\Http\Model\Common\SendSampleProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class SendSampleImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
    }
}
