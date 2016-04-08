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

        $this->assertEquals(trim($title), $poll->title);
        $this->assertEquals(trim($description), $poll->description);

        $this->assertEquals(is_array($answers) ? count($answers) : 0, $poll->answers()->count());
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
        $this->assertEquals($total + 1, $answer->votes);
        $this->assertEquals($total + 1, $poll->votes()->count());
        $this->assertEquals($total + 1, $answer->votes()->count());

        $status = $answer->vote($this->user);

        $this->assertFalse($status);
        $this->assertEquals($total + 1, $answer->votes);
        $this->assertEquals($total + 1, $poll->votes()->count());
        $this->assertEquals($total + 1, $answer->votes()->count());


        $this->assertTrue($answer->isVotedBy($this->user));

        $this->assertEquals($total + 1, $poll->totalVotes());
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
        $this->actingAs($this->user);

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
