<?php

namespace Shahruslan\BitrixAdmin\Dto;

class TabOption
{
    const TYPE_TEXT = "text";
    const TYPE_CHECKBOX = "checkbox";
    const TYPE_TEXTAREA = "textarea";
    const TYPE_SELECT = "select";
    const TYPE_MULTI_SELECT = "multi-select";

    private string $name;

    private string $label;

    private string $value;

    private string $type;

    private array $settings;

    public function __construct(string $name, string $label, string $value, string $type = self::TYPE_TEXT, array $settings = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->type = $type;
        $this->settings = $settings;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getSettings(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }
}
