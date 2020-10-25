<?php

namespace App\Models;

class Fangattr extends Base
{
    // 获取数据
    public function getList() {
        // 获取全部的数据
        $data = self::get()->toArray();
        // 调用父类中的递归层级函数
        return $this->treeLevel($data);
    }
}
