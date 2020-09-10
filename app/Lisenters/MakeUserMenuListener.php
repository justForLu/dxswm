<?php

namespace App\Listeners;

use App\Repositories\Admin\MenuRepository as Menu;
use App\Events\MakeUserMenu;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MakeUserMenuListener
{

    protected $menu;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Handle the event.
     *
     * @param  MakeUserMenu  $event
     * @return void
     */
    public function handle(MakeUserMenu $event)
    {
        //获取用户菜单
        $uid = Auth::user()->id;
        $userMenus = $this->menu->getUserMenuTree();

        // 缓存用户菜单
        Cache::store()->forever('menu_user_' . $uid, json_encode($userMenus));
    }
}
