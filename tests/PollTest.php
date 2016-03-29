<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PollTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\User;
     */
    protected $user;

    /**
     * @dataProvider pollsData
     *
     * @param string $title
     * @param string $description
     * @param array  $answers
     */
    public function testCreateFromArray($title, $description, $answers)
    {
        $poll = $this->createPoll($title, $description, $answers);

        $this->assertTrue($poll instanceof \App\Poll);
        $this->assertTrue($poll->exists());

        $this->assertEquals($poll->title, trim($title));
        $this->assertEquals($poll->description, trim($description));

        $this->assertEquals($poll->answers()->count(), is_array($answers) ? count($answers) : 0);
    }

    /**
     * @expectedException \App\Exceptions\PollVoteException
     */
    public function testNonExistsVoting()
    {
        $answer = new \App\PollAnswer();

        $answer->vote(
            factory(App\User::class)->create()
        );
    }

    /**
     * @expectedException \App\Exceptions\PollVoteException
     */
    public function testVoterNonExistsVoting()
    {
        $poll = $this->createPoll('Место проведения корпоратива', '', [
            'Кремль',
            'Эрмитаж',
            'Офис',
            'Дома',
        ]);

        $answer = $poll->answers()->first();
        $poll->vote(
            $answer,
            new App\User()
        );
    }

    public function testVoting()
    {
        $poll = $this->createPoll('Место проведения корпоратива', '', [
            'Кремль',
            'Эрмитаж',
            'Офис',
            'Дома',
        ]);

        $answer = $poll->answers()->first();

        $total = 5;
        factory(App\User::class, $total)->create()->each(function(App\User $user) use($poll, $answer) {
            $poll->vote($answer, $user);
        });

        $status = $answer->vote($this->user);

        $this->assertTrue($status);
        $this->assertEquals($answer->votes, $total + 1);
        $this->assertEquals($poll->votes()->count(), $total + 1);
        $this->assertEquals($answer->votes()->count(), $total + 1);

        $status = $answer->vote($this->user);

        $this->assertFalse($status);
        $this->assertEquals($answer->votes, $total + 1);
        $this->assertEquals($poll->votes()->count(), $total + 1);
        $this->assertEquals($answer->votes()->count(), $total + 1);


        $this->assertTrue($answer->isVotedBy($this->user));

        $this->assertEquals($poll->totalVotes(), $total + 1);
    }

    /**
     * @param string $title
     * @param string $description
     * @param array  $answers
     *
     * @return \App\Poll
     */
    protected function createPoll($title, $description, $answers)
    {
        $this->user = factory(App\User::class)->create();

        return \App\Poll::createFromArray([
            'title'       => $title,
            'description' => $description,
            'answers'     => $answers,
        ], $this->user);
    }

    /**
     * @return array
     */
    public function pollsData()
    {
        return [
            [
                'Место проведения корпоратива',
                'Скоро новый год и пора бы выбрать место празднования',
                [
                    'Кремль',
                    'Эрмитаж',
                    'Офис',
                    'Дома',
                ],
            ],
            [
                'Место проведения корпоратива',
                'Скоро новый год и пора бы выбрать место празднования',
                null,
            ],
            [
                'Место проведения корпоратива',
                '',
                null,
            ],
            [
                'Место проведения корпоратива',
                '',
                [
                    [
                        'title'       => 'Кремль',
                        'description' => 'празднование на красной площади',
                    ],
                    [
                        'title'       => 'Эрмитаж',
                        'description' => 'празднование и просмотр картин великих художников',
                    ],
                ],
            ],
        ];
    }
}
