<?php

namespace App\Http\Controllers\BaseControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class BackendController extends Controller
{
    private string $pageTitle = 'Dashboards';
    private string $pageHeaderTitle = 'Dashboards';
    private string $mainMenu = '';
    private string $subMenu = '';
    private string $activeMenu = 'dashboard';
    private array $pageBreadcrumbs = [];

    protected function setPageTitle(string $pageTitle, bool $setPageHeader=true): void
    {
        $this->pageTitle = $pageTitle;
        if ($setPageHeader) {
            $this->setPageHeaderTitle($pageTitle);
        }
    }
    protected function setPageHeaderTitle(string $pageHeaderTitle): void
    {
        $this->pageHeaderTitle = $pageHeaderTitle;
    }
    protected function setMainMenu(string $mainMenu): void
    {
        $this->mainMenu = $mainMenu;
    }
    protected function setSubMenu(string $subMenu): void
    {
        $this->subMenu = $subMenu;
    }
    protected function setActiveMenu(string $activeMenu): void
    {
        $this->activeMenu = $activeMenu;
    }

    protected function addBreadcrumbs($text,$link=null,$icon=null,$icon_custom=false) {
        $this->pageBreadcrumbs[] = [
            'text' => $text,
            'link' => $link,
            'icon' => $icon,
            'icon_custom' => $icon_custom,
        ];
    }
    protected function setBreadcrumbs(array $breadcrumbs) {
        foreach ($breadcrumbs as $breadcrumb) {
            $this->addBreadcrumbs($breadcrumb);
        }
    }

    protected function view($view): \Illuminate\Contracts\View\View
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



    protected function returnAjaxException($exception)
    {
        return response()->json([
            'status' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ]);
    }

    protected function returnAjaxSuccess(array $data, $message='Success')
    {
        $data['status'] = 200;
        $data['message'] = $message;
        return response()->json($data);
    }

    protected function returnAjaxError(array $data, $message='Error')
    {
        $data['status'] = 404;
        $data['message'] = $message;
        return response()->json($data);
    }

}
