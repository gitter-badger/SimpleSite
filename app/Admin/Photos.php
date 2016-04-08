<?php

use App\Photo;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Photo::class, function (ModelConfiguration $model) {

    $model->setTitle(trans('core.title.photos'));

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()->setColumns(
            AdminColumn::link('caption', trans('core.photo.field.caption')),
            AdminColumn::relatedLink('category.title', trans('core.photo.field.category')),
            AdminColumn::image('thumb', trans('core.photo.field.thumb'))
                ->setHtmlAttribute('class', 'text-center')
                ->setWidth('100px')
        )->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function () {
        return AdminForm::panel()
        ->setHtmlAttribute('enctype', 'multipart/form-data')
        ->addHeader(
            AdminFormElement::text('caption', trans('core.photo.field.caption'))->required(),
            AdminFormElement::date('created_at', trans('core.photo.field.created_at'))->setFormat('Y-m-d H:i:s')
        )->addBody(
            AdminFormElement::textarea('description', trans('core.photo.field.description'))->setRows(3),
            AdminFormElement::select('category_id', trans('core.photo.field.category'), new \App\PhotoCategory())
        )->addBody(
            AdminFormElement::image('upload_file', trans('core.photo.field.image')),
            AdminColumn::image('image')->setWidth('250px')
        );
    });

})->addMenuPage(Photo::class)->setIcon('fa fa-picture-o');
