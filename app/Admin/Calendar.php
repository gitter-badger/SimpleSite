<?php

use App\Calendar;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Calendar::class, function (ModelConfiguration $model) {

    $model->setTitle(trans('core.title.calendar'));

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()->setColumns(
            AdminColumn::link('description', trans('core.calendar.field.description')),
            AdminColumn::text('user.display_name', trans('core.calendar.field.user')),
            AdminColumn::datetime('start_at', trans('core.calendar.field.start_at'))->setFormat('d.m.Y H:i'),
            AdminColumn::datetime('end_at', trans('core.calendar.field.end_at'))->setFormat('d.m.Y H:i')
        )->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function () {
        return AdminForm::panel()->addHeader(
            AdminFormElement::text('description', trans('core.calendar.field.description'))
                ->required(),
            AdminFormElement::select('type', trans('core.calendar.field.type'), Calendar::getTypes())
        )->addBody(
            AdminFormElement::date('start_at', trans('core.calendar.field.start_at'))
                ->setFormat('Y-m-d H:i:00')
                ->required(),
            AdminFormElement::date('end_at', trans('core.calendar.field.end_at'))
                ->setFormat('Y-m-d H:i:00')
                ->required()
        )->addBody(
            AdminFormElement::select('user_id', trans('core.calendar.field.user'), new \App\User())
                ->setDisplay('display_name')
                ->required()
        );
    });

})->addMenuPage(Calendar::class)->setIcon('fa fa-calendar');
