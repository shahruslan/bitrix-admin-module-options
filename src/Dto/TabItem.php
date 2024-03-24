<?php

namespace Shahruslan\BitrixAdmin\Dto;

class TabItem
{
    private string $id;

    private string $name;

    private string $title;

    /** @var array<TabOption> */
    private array $options;

    public function __construct(string $id, string $name, string $title, array $options = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->options = array_filter($options, fn ($option) => $option instanceof TabOption);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return array|TabOption[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function toArray(): array
    {
        return [
            "DIV" => $this->id,
            "TAB" => $this->name,
            "TITLE" => $this->title,
        ];
    }
}
