<?php

use Illuminate\Database\Seeder;
use App\Http\Model\Common\Dictionary;

class DictionarySeeder extends Seeder
{
    public function run()
    {
        Dictionary::updateOrCreate(['id'=>'1'],['name'=>'platform_type','value'=>'抖音']);
        Dictionary::updateOrCreate(['id'=>'2'],['name'=>'platform_type','value'=>'快手']);

        Dictionary::updateOrCreate(['id'=>'100'],['name'=>'shop_category','value'=>'家居百货']);
        Dictionary::updateOrCreate(['id'=>'101'],['name'=>'shop_category','value'=>'生活用品']);
        Dictionary::updateOrCreate(['id'=>'102'],['name'=>'shop_category','value'=>'食品饮料']);

        Dictionary::updateOrCreate(['id'=>'200'],['name'=>'shop','value'=>'聚惠供应链']);
        Dictionary::updateOrCreate(['id'=>'201'],['name'=>'shop','value'=>'赵师傅甄慧选']);
    }
}
