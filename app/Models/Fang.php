<?php

namespace App\Models;

class Fang extends Base {

    // 修改器
    // 房子配置
    public function setFangConfigAttribute($value) {
        $this->attributes['fang_config'] = implode(',',$value);
    }
    // 房子图片
    public function setFangPicAttribute($value) {
        $this->attributes['fang_pic'] = trim($value,'#');
    }


    // 房东  属于关系
    public function owner() {
        return $this->belongsTo(FangOwner::class, 'fang_owner');
    }

    // 添加和修改关联数据
    public function relationData() {
        // 业主
        $ownerData = FangOwner::get();
        // 省份数据
        $cityData = City::where('pid', 0)->get();
        // 租期方式
        $fang_rent_type_id = Fangattr::where('field_name', 'fang_rent_type')->value('id');
        $fang_rent_type_data = Fangattr::where('pid', $fang_rent_type_id)->get();
        // 朝向
        $fang_direction_id = Fangattr::where('field_name', 'fang_direction')->value('id');
        $fang_direction_data = Fangattr::where('pid', $fang_direction_id)->get();
        // 租赁方式
        $fang_rent_class_id = Fangattr::where('field_name', 'fang_rent_class')->value('id');
        $fang_rent_class_data = Fangattr::where('pid', $fang_rent_class_id)->get();
        // 配套设施
        $fang_config_id = Fangattr::where('field_name', 'fang_config')->value('id');
        $fang_config_data = Fangattr::where('pid', $fang_config_id)->get();
        // 返回数据
        return [
            'ownerData' => $ownerData,
            'cityData' => $cityData,
            'fang_rent_type_data' => $fang_rent_type_data,
            'fang_direction_data' => $fang_direction_data,
            'fang_rent_class_data' => $fang_rent_class_data,
            'fang_config_data' => $fang_config_data
        ];
    }
}
