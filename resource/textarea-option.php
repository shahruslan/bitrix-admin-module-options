<?php
use Shahruslan\BitrixAdmin\Dto\TabOption;

/** @var TabOption $option */
?>

<!--suppress HtmlFormInputWithoutLabel -->
<textarea id="<?= $option->getName() ?>"
          name="<?= $option->getName() ?>"
          rows="<?= $option->getSettings('rows', 5) ?>"
          cols="<?= $option->getSettings('cols', 10) ?>"><?= htmlspecialchars($option->getValue()) ?></textarea>
