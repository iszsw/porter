<?php

namespace iszsw\curd\controller;

use iszsw\curd\Helper;
use iszsw\curd\lib\Manage;

class Table extends Common
{

    public function index()
    {
        return $this->createTable(new table\Table());
    }

    public function update()
    {
        return $this->createForm(new table\Form());
    }

    /**
     * 删除配置
     * Author: zsw zswemail@qq.com
     */
    public function delete()
    {
        $table = input('table');
        Manage::instance()->delete($table);
        return Helper::success("删除成功");
    }

}
