<?php
namespace App\Repositories\Admin\Contracts;


interface SendSampleInterface
{
    public function get($param);

    public function getPageData($param,$perPage);

    public function create($param);

    public function findById($id);

    public function update($param);

    public function destroy($id);
}
