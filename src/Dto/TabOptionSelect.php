<?php

namespace Shahruslan\BitrixAdmin\Dto;

class TabOptionSelect extends TabOption
{
    public function __construct(string $name, string $label, string $value, array $values = [], string $default = '')
    {
        $values = ['reference' => array_values($values), 'reference_id' => array_keys($values)];
        parent::__construct($name, $label, $value, self::TYPE_SELECT, compact('values', 'default'));
    }
}
