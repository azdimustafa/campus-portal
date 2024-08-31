<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Modules\Site\Entities\Menu;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    function buildSubMenu($parentMenu, $childMenus) {
        $submenu = [];
        foreach ($childMenus as $childMenu) {
            if ($childMenu->parent_id == $parentMenu->id) {
                $submenu[] = [
                    'text' => __($childMenu->name),
                    'icon' => $childMenu->icon,
                    'url' => $childMenu->route,
                    'active' => [$childMenu->route, $childMenu->route.'/*'],
                    'submenu' => $this->buildSubMenu($childMenu, $childMenus), // Recursive call
                ];
            }
        }
        // return $submenu;
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        if (php_sapi_name() === 'cli') {
            return;
        }
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            // MAIN MENU
            $event->menu->add([
                'key' => 'home', 
                'text' => __('Home'),
                'icon' => 'fas fa-fw fa-home',
                'url' => '/',
            ]);

            $event->menu->add([
                'key' => 'header_system',
                'header' => 'SYSTEM',
                'can'    => ['site-manage-organization', 'site-manage-user', 'site-manage-permission', 'site-developer', 'site-view-log', 'site-manage-setting'],
            ]);

            $event->menu->add([
                'text' => __('Organization'),
                'icon' => 'fas fa-fw fa-cogs',
                'url' => '#',
                'can' => ['site-manage-organization'],
                'submenu' => [
                    [
                        'text' => __('PTj'),
                        'route' => 'site.organization.ptjs.index',
                        'icon' => 'fa-fw fas fa-route',
                        'active' => ['site.organization.ptjs', 'site.organization.ptjs*'],
                        'can' => 'site-manage-organization',
                    ],
                    [
                        'text' => __('Department'),
                        'route' => 'site.organization.departments.index',
                        'icon' => 'fa-fw fas fa-route',
                        'active' => ['site.organization.departments', 'site.organization.departments*'],
                        'can' => 'site-manage-organization',
                    ],
                ]   
            ]);

            $event->menu->add([
                'text' => __('Administration'),
                'icon' => 'fas fa-fw fa-cogs',
                'url' => '#',
                'can' => ['site-manage-user', 'site-manage-permission'],
                'submenu' => [
                    [
                        'text' => __('Users'),
                        'route' => 'site.users.index',
                        'icon' => 'fa-fw fas fa-users',
                        'active' => ['site.users', 'site.users*'],
                        'can' => 'site-manage-user',
                    ],
                    [
                        'text' => __('Permissions'),
                        'route' => 'site.permissions.index',
                        'icon' => 'fa-fw fas fa-lock',
                        'active' => ['site.permissions', 'site.permissions*'],
                        'can' => 'site-manage-permission',
                    ],
                    [
                        'text' => __('Roles'),
                        'route' => 'site.roles.index',
                        'icon' => 'fa-fw fas fa-project-diagram',
                        'active' => ['site.roles', 'site.roles*'],
                        'can' => 'site-manage-permission',
                    ],
                ]
            ]);

            $event->menu->add([
                'text' => __('Developer'),
                'icon' => 'fas fa-fw fa-cogs',
                'url' => '#',
                'can' => ['site-developer', 'site-view-log', 'site-manage-setting'],
                'submenu' => [
                    [
                        'text' => __('Settings'),
                        'route' => 'site.settings.index',
                        'icon' => 'fa-fw fas fa-cogs',
                        'active' => ['site.settings', 'site.settings*'],
                        'can' => 'site-manage-setting',
                    ],
                    [
                        'text' => __('Logs'),
                        'route' => 'logs',
                        'icon' => 'fa-fw fas fa-clipboard-list',
                        'can' => 'site-view-log',
                    ],
                    [
                        'text' => __('How To'),
                        'icon' => 'fas fa-fw fa-question-circle',
                        'url' => '#',
                        'can' => 'site-developer',
                        'submenu' => [
                            [
                                'text' => __('Naming Convention'),
                                'route' => 'site.developer.naming-conventions',
                                'icon' => 'fa-fw fas fa-file',
                                'active' => ['site.developer.naming-conventions'],
                                'can' => 'site-developer',
                            ],
                            [
                                'text' => __('Do & Dont'),
                                'route' => 'site.developer.do-dont',
                                'icon' => 'fa-fw fas fa-file',
                                'active' => ['site.developer.do-dont'],
                                'can' => 'site-developer',
                            ],
                            [
                                'text' => __('Model Audit'),
                                'route' => 'site.developer.model-audit',
                                'icon' => 'fa-fw fas fa-file',
                                'active' => ['site.developer.model-audit'],
                                'can' => 'site-developer',
                            ],
                            [
                                'text' => __('Route Name'),
                                'route' => 'site.developer.route-name',
                                'icon' => 'fa-fw fas fa-file',
                                'active' => ['site.developer.route-name'],
                                'can' => 'site-developer',
                            ],
                            [
                                'text' => __('Other Example'),
                                'route' => 'site.developer.other-example',
                                'icon' => 'fa-fw fas fa-file',
                                'active' => ['site.developer.other-example'],
                                'can' => 'site-developer',
                            ],
                            [
                                'text' => __('Form Input'),
                                'route' => 'site.developer.form-input',
                                'icon' => 'fa-fw fas fa-file',
                                'active' => ['site.developer.form-input'],
                                'can' => 'site-developer',
                            ],
                        ]
                    ],
                    
                ]   
            ]);

            $event->menu->add([
                'text' => __('Help'),
                'icon' => 'fas fa-fw fa-question', 
                'url' => '#', 
                
                'topnav_right' => true,
                'submenu' => [
                    [
                        'text' => __('What\'s new'), 
                        'url' => '#',
                        // 'icon' => 'fas fa-fw fa-newpaper', 
                    ],
                    [
                        'text' => __('Helpdesk'), 
                        'url' => 'https://helpdesk.um.edu.my',
                        'target' => '_blank',
                        // 'icon' => 'fas fa-fw fa-question',
                    ],
                    [
                        'text' => __('Contact Us'), 
                        'url' => '#',
                        // 'icon' => 'fas fa-fw fa-th-list',
                    ],
                    [
                        'text' => __('Feedback'), 
                        'url' => '#',
                        // 'icon' => 'fas fa-fw fa-comments',
                    ],
                ],
            ]);
        });
    }
}
