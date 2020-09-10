<?php
namespace App\Services;

class TreeService
{
    //主键
    private static $primary = 'id';
    
    //父键
    private static $parentId = 'parent';
    
    //子节点名称
    private static $child = 'children';
    
    public static function setConfig($primary = '', $parentId = '', $child = ''){
        if(!empty($primary)) self::$primary  = $primary;
        if(!empty($prentId)) self::$parentId = $parentId;
        if(!empty($child))   self::$child    = $child;
    }
    
    public static function makeTree(&$data, $index = 0)
    {
        $children = self::findChild($data, $index);
        if(empty($children))
        {
            return $children;
        }
        foreach($children as $k => &$v)
        {
            if(empty($data)) break;
            $child = self::makeTree($data, $v['id']);
            if(!empty($child))
            {
                $v[self::$child] = $child;
            }
        }
        unset($v);
        return $children;
    }

    public static function findChild(&$data, $index)
    {
        $children = [];
        foreach ($data as $k => $v){
            if($v[self::$parentId] == $index){
                $children[]  = $v;
                unset($v);
            }
        }
        return $children;
    }
}