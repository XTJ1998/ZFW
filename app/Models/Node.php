<?php

namespace App\Models;

class Node extends Base {

    // 修改器 route_name   RouteName  set字段名Attribute 字段名首字母大写，遇下划线后字母大写
    public function setRouteNameAttribute($value) {
        // 如果字段值为null，则设置为空字符串  修改和添加时生效  create 或 update
        $this->attributes['route_name'] = empty($value) ? '' : $value;
    }

    // 访问器  menu Menu
    public function getMenuAttribute() {
        return $this->is_menu == '1' ? '<span class="label label-success radius">是</span>' : '<span class="label label-danger radius">否</span>';
    }

    // 获取全部的数据
    public function getAllList() {
        $data = self::get()->toArray();
        return $this->treeLevel($data);
    }

    /**
     * 获取层级的数据
     * @param $allow_node 用户有的权限
     * @return array
     */
    public function treeData($allow_node) {
        $query = Node::where('is_menu', '1');
        if (is_array($allow_node)) {
            $query->whereIn('id', array_keys($allow_node));
        }
        $menuData = $query->get()->toArray();

        return $this->subTree($menuData);
    }


}
