<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuItemsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file.
	 *
	 * @return void
	 */
	public function run()
	{
		if (file_exists(base_path('routes/web.php'))) {
			require base_path('routes/web.php');
			$this->seedAdminMenu();
			$this->seedMainMenu();
		}
	}

	/**
	 * Seed Admin Menu
	 */
	public function seedAdminMenu()
	{
		$menu = Menu::where('name', 'admin')->firstOrFail();

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '控制台',
			'url' => route('voyager.dashboard', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-boat',
				'color' => null,
				'parent_id' => null,
				'order' => 1,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '媒体库',
			'url' => route('voyager.media.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-images',
				'color' => null,
				'parent_id' => null,
				'order' => 5,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '内容',
			'url' => route('voyager.posts.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-news',
				'color' => null,
				'parent_id' => null,
				'order' => 6,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '用户',
			'url' => route('voyager.users.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-person',
				'color' => null,
				'parent_id' => null,
				'order' => 3,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '分类',
			'url' => route('voyager.categories.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-categories',
				'color' => null,
				'parent_id' => null,
				'order' => 8,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '页面',
			'url' => route('voyager.pages.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-file-text',
				'color' => null,
				'parent_id' => null,
				'order' => 7,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '角色',
			'url' => route('voyager.roles.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-lock',
				'color' => null,
				'parent_id' => null,
				'order' => 2,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '菜单',
			'url' => route('voyager.menus.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-list',
				'color' => null,
				'parent_id' => null,
				'order' => 10,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '数据库',
			'url' => route('voyager.database.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-data',
				'color' => null,
				'parent_id' => null,
				'order' => 11,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '设置',
			'url' => route('voyager.settings.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-settings',
				'color' => null,
				'parent_id' => null,
				'order' => 12,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '结构',
			'url' => route('voyager.data_rows.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-bar-chart',
				'color' => null,
				'parent_id' => null,
				'order' => 12,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '图文',
			'url' => route('voyager.banners.index', [], false),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-photo',
				'color' => null,
				'parent_id' => null,
				'order' => 12,
			])->save();
		}
	}

	/**
	 * Seed Main Menu
	 */
	public function seedMainMenu()
	{
		$menu = Menu::where('name', 'main')->firstOrFail();
		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '首页',
			'url' => '/',
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-browser',
				'color' => null,
				'parent_id' => null,
				'order' => 1,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '内容',
			'url' => url('/posts'),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-news',
				'color' => null,
				'parent_id' => null,
				'order' => 2,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '用户',
			'url' => url('/users'),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-person',
				'color' => null,
				'parent_id' => null,
				'order' => 3,
			])->save();
		}

		$menuItem = MenuItem::firstOrNew([
			'menu_id' => $menu->id,
			'title' => '关于',
			'url' => url('/about'),
		]);
		if (! $menuItem->exists) {
			$menuItem->fill([
				'target' => '_self',
				'icon_class' => 'voyager-categories',
				'color' => null,
				'parent_id' => null,
				'order' => 8,
			])->save();
		}

	}

}
