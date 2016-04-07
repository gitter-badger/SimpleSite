<?php

use App\Post;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Post::class, function (ModelConfiguration $model) {

    $model->setTitle(trans('core.title.news'));

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()->setColumns([
            AdminColumn::link('title')->setLabel(trans('core.post.field.title')),
        ])->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::panel()
        ->addHeader(
            AdminFormElement::text('title', trans('core.post.field.title'))->required()
        )
        ->addHeader(
            AdminFormElement::select('type', trans('core.post.field.type'), [
                Post::TYPE_EVENT => trans('core.post.label.event'),
                Post::TYPE_NEWS => trans('core.post.label.news')
            ]),
            AdminFormElement::date('event_date', trans('core.post.field.event_date'))
        )
        ->addBody(
            AdminFormElement::wysiwyg('text_source', trans('core.post.field.text'), 'simplemde')
                ->required()
                ->disableFilter(),
            AdminFormElement::image('upload_file', trans('core.post.field.image')),
            AdminColumn::image('image')->setWidth('300px')
        )->addBody(
            AdminFormElement::multiselect('photo_categories', trans('core.post.field.photo_categories'), new \App\PhotoCategory())
                ->setDisplay('title')
        )->addBody(
            AdminFormElement::multiselect('polls', trans('core.post.field.polls'), new \App\Poll())
                ->setDisplay('title')
        )
            ->setHtmlAttribute('enctype', 'multipart/form-data');
    });

})->addMenuPage(Post::class)->setIcon('fa fa-newspaper-o');
