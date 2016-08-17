<?php

use ExpoHub\Comment;
use ExpoHub\News;
use ExpoHub\User;
use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$news  = News::all()->lists('id');
		$users = User::all()->lists('id');

        factory(Comment::class, 200)->create([
			'news_id' => $news->first(),
			'user_id' => $users->first()
		])->each(function (Comment $comment) use($news, $users) {
			$comment->news_id = $news->random();
			$comment->user_id = $users->random();
			$comment->save();
		});
    }
}
