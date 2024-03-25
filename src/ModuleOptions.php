<?php

namespace Shahruslan\BitrixAdmin;

use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Localization\Loc;
use CAdminTabControl;
use CMain;
use Shahruslan\BitrixAdmin\Dto\TabItem;

class ModuleOptions
{
    private CAdminTabControl $tabControl;

    private CMain $application;

    private HttpRequest $request;

    /** @var array<TabItem> */
    private array $tabs;

    private string $moduleId;

    protected string $modRight;

    public function __construct(string $moduleId, array $tabs)
    {
        $this->moduleId = $moduleId;
        $this->tabs = array_filter($tabs, fn ($tab) => $tab instanceof TabItem);
        $this->modRight = (string) CMain::GetGroupRight($this->moduleId);
        $this->request = Context::getCurrent()->getRequest();
        $this->application = $GLOBALS['APPLICATION'] ?? new CMain();
        $arrayTabs = array_map(fn (TabItem $t) => $t->toArray(), $this->tabs);
        $this->tabControl = new CAdminTabControl("tabControl", $arrayTabs);
        Loc::loadMessages($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/options.php");
    }

    public function render(): string
    {
        if ($this->modRight < 'R') {
            return '';
        }

        $template = new Template();

        return $template->render('edit-form', [
            'tabControl' => $this->tabControl,
            'module_id' => $this->moduleId,
            'baseUrl' => $this->getBaseUrl(),
            'tabs' => $this->tabs,
            'modRight' => $this->modRight,
            'backUrlSettings' => $this->request->getPost('back_url_settings') ?: null,
            'APPLICATION' => $this->application,
        ]);
    }

    public function saveSettings(): void
    {
        if ($this->request->isPost() == false || check_bitrix_sessid() == false || $this->modRight !== 'W') {
            return;
        }

        $redirect = $this->getBaseUrl();

        if ($this->request->getPost('RestoreDefaults')) {
            /** @noinspection PhpUnhandledExceptionInspection */
            Option::delete($this->moduleId);
        }

        if ($this->request->getPost('Update') || $this->request->getPost('Apply')) {

            foreach ($this->tabs as $tab) {
                foreach ($tab->getOptions() as $option) {
                    $val = $this->request->getPost($option->getName());
                    try { Option::set($this->moduleId, $option->getName(), $val);
                    } catch (ArgumentOutOfRangeException $e) {}
                }
            }
        }

        if (strlen($redirect) > 0) {
            LocalRedirect($redirect);
        }
    }

    private function getBaseUrl(): string
    {
        $params = sprintf(
            "mid=%s&lang=%s&%s",
            urlencode($this->moduleId),
            urlencode(LANGUAGE_ID),
            $this->tabControl->ActiveTabParam(),
        );
        return $this->application->GetCurPageParam($params, ["mid", "lang"]);
    }
}
