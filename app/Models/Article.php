<?php

namespace App\Models;

class Article extends Base {
    // 追加一个字段 集合访问器
    protected $appends = ['action'];

    // 访问器
    public function getActionAttribute() {
        return $this->editBtn('admin.article.edit').'&nbsp;'.$this->deleteBtn('admin.article.destroy');
    }
}
