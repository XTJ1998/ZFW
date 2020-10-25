<?php

namespace App\Exports;

use App\Models\FangOwner;
use Maatwebsite\Excel\Concerns\FromCollection;

class FangOwnerExport implements FromCollection
{
    /**
    * 房东信息列表
    */
    public function collection()
    {
        return FangOwner::all();
    }
}
