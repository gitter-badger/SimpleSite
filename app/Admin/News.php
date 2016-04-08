<?php

use App\Post;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Post::class, function (ModelConfiguration $model) {

    $model->setTitle(trans('core.title.news'));

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()
           ->setColumns([
               AdminColumn::link('title')->setLabel(trans('core.post.field.title')),
               AdminColumn::datetime('created_at')->setLabel(trans('core.post.field.created_at'))->setFormat('d.m.Y H:i')->setWidth('150px'),
               AdminColumnEditable::checkbox('is_pinned')->setLabel(trans('core.post.field.is_pinned'))->setWidth('100px'),
           ])->paginate(20);

        $display->setScopes([['latest']]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::panel()
        ->addHeader(
            AdminFormElement::text('title', trans('core.post.field.title'))->required(),
            AdminFormElement::date('created_at', trans('core.post.field.created_at'))->setFormat('Y-m-d H:i:s')
        )
        ->addHeader(
            AdminFormElement::select('type', trans('core.post.field.type'), [
                Post::TYPE_EVENT => trans('core.post.label.event'),
                Post::TYPE_NEWS => trans('core.post.label.news')
            ]),
            AdminFormElement::date('event_at', trans('core.post.field.event_at'))->setFormat('Y-m-d H:i:00')
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
                ->setDisplay('title'),

            AdminFormElement::custom()->setCallback(function(Post $post) {
                if (is_null($post->author_id)) {
                    $post->assignAuthor(auth()->user());
                }
            })
        )
            ->setHtmlAttribute('enctype', 'multipart/form-data');
    });

})->addMenuPage(Post::class)->setIcon('fa fa-newspaper-o');
