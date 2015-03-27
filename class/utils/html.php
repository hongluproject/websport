<?php

namespace Utils;

class Html
{
    /**
     * 创建自动完成控件
     *
     * @static
     * @param      $name
     * @param null $default
     * @return string
     */
    public static function buildAutoCompleteInput($model, $name, $default = null, array $attr = array())
    {
        $default_title = '';
        if ($default && is_numeric($default))
        {
            $class_name = "\\Model\\$model";
            $model = $class_name::find($default);
            $default_title = $model->title;
        }

        return \Core\Html::tag('input', $default_title, array('ac-type'  => $model,
                                                              'ac-data'  => '[name=\'' . $name . '\']',
                                                              'class'    => 'ac input-xxlarge') + $attr) .
            \Core\Html::tag('input', $default, array('name' => $name,
                                                     'type' => 'hidden'));
    }
}