<?php

use App\Poll;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Poll::class, function (ModelConfiguration $model) {

    $model->setTitle(trans('core.title.polls'));

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()->setColumns([
            AdminColumn::link('title', trans('core.poll.field.title')),
            AdminColumn::text('total_votes', trans('core.poll.field.total_votes')),
        ])->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function () {
        return AdminForm::panel()->addHeader(
            AdminFormElement::text('title', trans('core.poll.field.title'))
                ->required(),
            AdminFormElement::textarea('description', trans('core.poll.field.description'))
                ->setRows(3)
        )->addBody(
            AdminFormElement::multiselect('answers', trans('core.poll.field.answers'), new \App\PollAnswer())
                ->taggable()
                ->deleteRelatedItem()
                ->setDisplay('title')
        );
    });

})->addMenuPage(Poll::class)->setIcon('fa fa-bar-chart');
