<?php

namespace App\Enums;

use Artisaninweb\Enum\Enum;
use Illuminate\Support\Facades\Log;
use ReflectionClass;

/**
 * @method static BaseEnum ENUM()
 */
class BaseEnum extends Enum {

    /**
     * Returns the description of this enum
     *
     * @param $key
     * @return null
     * @throws \ReflectionException
     */
    public static function getEnumDesc($key){
        $reflection = new ReflectionClass(get_called_class());

        if($reflection->hasProperty('desc')){
            $desc  = $reflection->getStaticPropertyValue ('desc');
            return $desc[$key];
        }else{
            return null;
        }

    }

    /**
     * 获取枚举类的描述
     * @param $value
     * @return |null
     * @throws \ReflectionException
     */
    public static function getDesc($value)
    {
        $enumItems = self::getEnumValues();

        foreach($enumItems as $key => $val){
            if($value == $val->getConstValue()){
                return self::getEnumDesc($val->getConstName());
                break;
            }
        }
    }

    /**
     * 获取枚举下拉选框
     * @param $select
     * @param null $default
     * @param null $name
     * @param string $class
     * @param array $except
     * @throws \ReflectionException
     */
    public static function enumSelect($select,$default=null,$name=null,$class='form-control',$except=array())
    {
        $template = '<select name="'.$name.'" class="'.$class.'">';

        //设置多选默认项
        if($default){
            $template .= '<option value="">'.$default.'</option>';
        }

        $enumItems = self::getEnumValues();

        if($enumItems){
            foreach($enumItems as $key=>$val){
                if(!in_array($key, $except)){
                    if($select == $val->getConstValue() && $select != null){
                        $template .= '<option selected="selected" value="'.$val->getConstValue().'">'.self::getEnumDesc($key).'</option>';
                    }else{
                        $template .= '<option value="'.$val->getConstValue().'">'.self::getEnumDesc($key).'</option>';
                    }
                }
            }
        }

        $template .= '</select>';

        echo $template;
    }

    /**
     * 读取枚举数组
     * @return array
     * @throws \ReflectionException
     */
    public static function enumItems()
    {
        $enumArr = array();

        $enumItems = self::getEnumValues();

        if($enumItems) {
            foreach ($enumItems as $key => $val) {
                $enumArr[] = array(
                    'key' => $val->getConstValue(),
                    'value' => self::getEnumDesc($key)
                );
            }
        }

        return $enumArr;
    }

    /**
     * 获取枚举单选框
     * @param $select
     * @param null $name
     * @param string $class
     * @param array $except
     * @throws \ReflectionException
     */
    public static function enumRadio($select,$name=null,$class='radio-inline',$except=array())
    {
        $template = '';

        $enumItems = self::getEnumValues();

        if($enumItems){
            foreach($enumItems as $key=>$val){
                if(!in_array($key, $except)){
                    if($select == $val->getConstValue() && $select !== null){
                        $template .= '<label class="'.$class.'"><input name="'.$name.'" type="radio" value="'.$val->getConstValue().'" checked>'.self::getEnumDesc($key).'</label>';
                    }else{
                        $template .= '<label class="'.$class.'"><input name="'.$name.'" type="radio" value="'.$val->getConstValue().'">'.self::getEnumDesc($key).'</label>';
                    }

                }
            }
        }


        echo $template;
    }
}
