<?php
use Shahruslan\BitrixAdmin\Dto\TabOption;

/** @var TabOption $option */
?>

<!--suppress HtmlFormInputWithoutLabel -->
<input id="<?= $option->getName() ?>"
       type="text"
       name="<?= $option->getName() ?>"
       value="<?= htmlspecialchars($option->getValue()) ?>"
       size="<?= $option->getSettings('size', 30) ?>"
       maxlength="<?= $option->getSettings('max', 255) ?>">
