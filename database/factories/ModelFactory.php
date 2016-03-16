<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(ExpoHub\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'username' => $faker->unique()->word,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(ExpoHub\Category::class, function(Faker\Generator $faker) {
	return [
		'name' => $faker->word
	];
});

$factory->define(\ExpoHub\Comment::class, function(Faker\Generator $faker) {
	return [
		'text' => $faker->paragraph()
	];
});

$factory->define(\ExpoHub\EventType::class, function(\Faker\Generator $faker) {
	return [
		'name' => $faker->word
	];
});

$factory->define(\ExpoHub\Fair::class, function(\Faker\Generator $faker) {
	return [
		'name' => $faker->title,
		'image' => $faker->imageUrl(),
		'description' => $faker->paragraph(),
		'website' => $faker->url,
		'starting_date' => \Carbon\Carbon::now()->subDay(rand(1, 4)),
		'ending_date' => \Carbon\Carbon::now()->addDays(rand(1, 4)),
		'address' => $faker->word,
		'latitude' => $faker->latitude,
		'longitude' => $faker->longitude
	];
});

$factory->define(\ExpoHub\FairEvent::class, function(\Faker\Generator $faker) {
	return [
		'title' => $faker->title,
		'image' => $faker->imageUrl(),
		'description' => $faker->paragraph(),
		'date' => \Carbon\Carbon::now(),
		'location' => $faker->sentence()
	];
});

$factory->define(\ExpoHub\Map::class, function(\Faker\Generator $faker) {
	return [
		'name' => $faker->word,
		'image' => $faker->imageUrl()
	];
});

$factory->define(\ExpoHub\News::class, function(\Faker\Generator $faker) {
	return [
		'title' => $faker->title,
		'content' => $faker->paragraph(),
		'image' => $faker->imageUrl()
	];
});

$factory->define(\ExpoHub\Speaker::class, function(\Faker\Generator $faker) {
	return [
		'name' => $faker->name,
		'picture' => $faker->imageUrl(),
		'description' => $faker->paragraph()
	];
});

$factory->define(\ExpoHub\Sponsor::class, function(\Faker\Generator $faker) {
	return [
		'name' => $faker->name,
		'logo' => $faker->imageUrl(),
		'slogan' => $faker->sentence(),
		'website' => $faker->url
	];
});

$factory->define(\ExpoHub\SponsorRank::class, function(\Faker\Generator $faker) {
	return [
		'name' => $faker->word
	];
});

$factory->define(\ExpoHub\Stand::class, function(\Faker\Generator $faker) {
	return [
		'name' => $faker->word,
		'description' => $faker->paragraph(),
		'image' => $faker->imageUrl()
	];
});