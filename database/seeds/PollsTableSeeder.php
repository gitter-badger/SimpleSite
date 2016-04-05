<?php

use Illuminate\Database\Seeder;

class PollsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Poll::truncate();
        App\PollAnswer::truncate();
        App\PollVote::truncate();

        App\Poll::createFromArray([
            'title' => 'Место проведения корпоратива',
            'description' => 'Скоро новый год и пора бы выбрать место празднования',
            'answers' => [
                'Кремль',
                'Эрмитаж',
                'Офис',
                'Дома',
            ],
        ], App\User::first());
    }
}
