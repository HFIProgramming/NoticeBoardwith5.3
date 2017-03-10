<?php

$factory->define(App\Vote::class, function (Faker\Generator $faker) {
    static $dummy_intro = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis';

    return [
        'title' => str_random(10),
        'user_id' => 1,
        'intro' => $dummy_intro,
        'end_word' => 'Thank you for your vote!',
        'type' => '2',
        'started_at' => '2017-01-01',
        'ended_at' => '2018-01-01',
    ];
});