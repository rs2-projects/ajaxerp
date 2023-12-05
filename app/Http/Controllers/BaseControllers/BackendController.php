<?php

namespace App\Http\Controllers\BaseControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class BackendController extends Controller
{
    public string $pageTitle = 'Dashboard';
    public string $pageHeaderTitle = 'Dashboards';
    public string $mainMenu = '';
    public string $subMenu = '';
    public string $activeMenu = 'dashboard';
    public array $pageBreadcrumbs = [];

    public function setPageTitle(string $pageTitle, bool $setPageHeader=true): void
    {
        $this->pageTitle = $pageTitle;
        if ($setPageHeader) {
            $this->setPageHeaderTitle($pageTitle);
        }
    }
    public function setPageHeaderTitle(string $pageHeaderTitle): void
    {
        $this->pageHeaderTitle = $pageHeaderTitle;
    }
    public function setMainMenu(string $mainMenu): void
    {
        $this->mainMenu = $mainMenu;
    }
    public function setSubMenu(string $subMenu): void
    {
        $this->subMenu = $subMenu;
    }
    public function setActiveMenu(string $activeMenu): void
    {
        $this->activeMenu = $activeMenu;
    }

    public function addBreadcrumbs($text,$link=null,$icon=null,$icon_custom=false) {
        $this->pageBreadcrumbs[] = [
            'text' => $text,
            'link' => $link,
            'icon' => $icon,
            'icon_custom' => $icon_custom,
        ];
    }
    public function setBreadcrumbs(array $breadcrumbs) {
        foreach ($breadcrumbs as $breadcrumb) {
            $this->addBreadcrumbs($breadcrumb);
        }
    }

    public function view($view): \Illuminate\Contracts\View\View
    {
        return view($view)->with([
            'pageTitle' => $this->pageTitle,
            'pageHeaderTitle' => $this->pageHeaderTitle,
            'pageBreadcrumbs' => $this->pageBreadcrumbs,
            'mainMenu' => $this->mainMenu,
            'subMenu' => $this->subMenu,
            'activeMenu' => $this->activeMenu
        ]);
    }

}
