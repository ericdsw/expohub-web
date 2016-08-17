<?php

use ExpoHub\Category;
use ExpoHub\Fair;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fairs = Fair::all()->lists('id');
		factory(Category::class, 40)->create([
			'fair_id' => $fairs->first()
		])->each(function (Category $category) use ($fairs) {
			$category->fair_id = $fairs->random();
			$category->save();
		});
    }
}
