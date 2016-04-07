<?php

use App\PhotoCategory;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(PhotoCategory::class, function (ModelConfiguration $model) {

    $model->setTitle(trans('core.title.gallery'));

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()->setColumns([
            AdminColumn::link('title', trans('core.gallery.field.title')),
        ])->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function () {
        return AdminForm::panel()->addHeader(
            AdminFormElement::text('title', trans('core.poll.field.title'))
                ->required(),
            AdminFormElement::textarea('description', trans('core.poll.field.description'))
                ->setRows(3)
        );
    });

})->addMenuPage(PhotoCategory::class)->setIcon('fa fa-picture-o');
