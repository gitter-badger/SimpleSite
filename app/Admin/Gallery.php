<?php

use App\PhotoCategory;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(PhotoCategory::class, function (ModelConfiguration $model) {

    $model->setTitle(trans('core.title.gallery'));

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()->setColumns(
            AdminColumn::link('title', trans('core.gallery.field.title')),
            AdminColumn::count('photos', trans('core.gallery.label.total_photos'))
                ->setHtmlAttribute('class', 'text-center')
                ->setWidth('100px')
        )->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function () {
        return AdminForm::panel()->addHeader(
            AdminFormElement::text('title', trans('core.gallery.field.title'))->required(),
            AdminFormElement::date('created_at', trans('core.gallery.field.created_at'))->setFormat('Y-m-d H:i:s')
        )->addBody(
            AdminFormElement::textarea('description', trans('core.gallery.field.description'))->setRows(3)
        )->addBody(
            AdminFormElement::relatedImages('photos', trans('core.gallery.field.photos'))
        );
    });

})->addMenuPage(PhotoCategory::class)->setIcon('fa fa-picture-o');
