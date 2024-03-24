<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Shahruslan\BitrixAdmin\Dto\TabItem;
use Shahruslan\BitrixAdmin\Template;

/** @var CAdminTabControl $tabControl */
/** @var string $module_id */
/** @var string $baseUrl */
/** @var array<TabItem> $tabs */
/** @var Template $this */
/** @var string $modRight */
/** @var string|null $backUrlSettings */

$disabled = $modRight < 'W' ? 'disabled' : '';
$restoreMess = AddSlashes(Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"));
?>

<?php $tabControl->Begin() ?>

<form method="POST" action="<?= $baseUrl ?>" name="settings">
    <?= bitrix_sessid_post() ?>

    <?php foreach ($tabs as $tab) : ?>
        <?php $tabControl->BeginNextTab() ?>
        <?php if($tab->getId() === "rights") : ?>
            <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/admin/group_rights.php"); ?>
        <?php endif; ?>
        <?php foreach ($tab->getOptions() as $option) : ?>
            <?php $value = Option::get($module_id, $option->getName())?>
            <tr>
                <td valign="top" width="30%">
                    <label for="<?= htmlspecialchars($option->getName()) ?>">
                        <?= htmlspecialchars($option->getLabel()) ?>
                    </label>
                </td>
                <td valign="top" width="70%">
                    <?= $this->renderOption($option) ?>
                </td>
            </tr>
        <?php endforeach ?>
    <?php endforeach ?>

    <?php $tabControl->Buttons() ?>

    <input type="submit" name="Update" <?= $disabled ?> value="<?= Loc::getMessage("SHAHRUSLAN_SEARCH_OPTIONS_BUTTON_SAVE") ?>">
    <input type="hidden" name="Update" value="Y">

    <?php if ($backUrlSettings !== null): ?>
        <input type="button" name="Cancel" onclick="window.location='<?= $backUrlSettings ?>'" value="<?= Loc::getMessage("SHAHRUSLAN_SEARCH_OPTIONS_BUTTON_CANCEL") ?>">
    <?php endif ?>

    <input type="reset" name="reset" value="<?= Loc::getMessage("SHAHRUSLAN_SEARCH_OPTIONS_BUTTON_RESET") ?>">
    <input type="submit" <?= $disabled ?> name="RestoreDefaults" OnClick="return confirm('<?= $restoreMess ?>')" value="<?= Loc::getMessage("SHAHRUSLAN_SEARCH_OPTIONS_BUTTON_RESTORE") ?>">

    <?php $tabControl->End() ?>
</form>
