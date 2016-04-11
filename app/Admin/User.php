<?php

use App\Role;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
    $model->setTitle(trans('core.title.users'));

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()
            ->with('roles')
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::link('name', trans('core.user.field.username')),
                AdminColumn::email('email', trans('core.user.field.email'))->setWidth('150px'),
                AdminColumn::lists('roles.label', trans('core.user.field.roles'))->setWidth('200px'),
            ])->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::panel()
            ->setHtmlAttribute('enctype', 'multipart/form-data')
            ->addHeader(
                AdminFormElement::columns()
                    ->addColumn(function() {
                        return [
                            AdminFormElement::text('name', 'Username')->required(),
                            AdminFormElement::text('display_name', 'Display name'),
                            AdminFormElement::text('email', 'E-mail')->required()->addValidationRule('email')
                        ];
                    })->addColumn(function() {
                        return [
                            AdminColumn::image('avatar')->setWidth('150px'),
                        ];
                    })->addColumn(function() {
                        return [
                            AdminFormElement::image('avatar', trans('core.user.field.avatar'))
                        ];
                    })
            )
            ->addBody(
                AdminFormElement::password('password', 'Password')->required()->addValidationRule('min:6'),
                AdminFormElement::multiselect('roles', 'Roles')->setModelForOptions(new Role())->setDisplay('name')
            );
    });
});
