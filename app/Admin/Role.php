<?php

use App\Role;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Role::class, function (ModelConfiguration $model) {
    $model->setTitle(trans('core.title.roles'));

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()->with('users')
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('id')->setLabel('#')->setWidth('30px'),
                AdminColumn::link('label')->setLabel('Label')->setWidth('100px'),
                AdminColumn::text('name')->setLabel('Name')
            ])->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Key')->required(),
            AdminFormElement::text('label', 'Label')->required()
        ]);
    });
});
