<?php

namespace Shahruslan\BitrixAdmin;

use Shahruslan\BitrixAdmin\Dto\TabOption;

class Template
{
    public function render(string $template, array $params = []): string
    {
        $file = dirname(__DIR__) . "/resource/" . $template . '.php';

        if (file_exists($file) === false) {
            throw new \Exception('Template not found: ' . $file);
        }

        ob_start();
        extract($params);
        include $file;
        return ob_get_clean();
    }

    public function renderOption(TabOption $option)
    {
        $value = htmlspecialchars($option->getValue());

        if ($option->getType() === TabOption::TYPE_CHECKBOX) {
            return InputType('checkbox', $option->getName(), 'Y', $value, false, '', $option->getName());
        }

        if ($option->getType() === TabOption::TYPE_SELECT) {
            return SelectBoxFromArray(
                $option->getName(),
                $option->getSettings('values', []),
                $value,
                $option->getSettings('default', ''),
            );
        }

        if ($option->getType() === TabOption::TYPE_MULTI_SELECT) {
            //todo удалить дублирующий иденитификатор
            return SelectBoxMFromArray(
                "{$option->getName()}[]",
                $option->getSettings('values', []),
                [$value],
                '',
                "id=\"{$option->getName()}\""
            );
        }

        if ($option->getType() === TabOption::TYPE_TEXT) {
            return $this->render('text-option', compact('option'));
        }

        if ($option->getType() === TabOption::TYPE_TEXTAREA) {
            return $this->render('textarea-option', compact('option'));
        }
    }
}
