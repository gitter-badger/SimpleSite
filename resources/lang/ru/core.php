<?php

return [
    'title' => [
        'portal' => 'Корпоративный портал Инфозащита',
        'index' => 'Главная',
        'news' => 'Новости',
        'polls' => 'Опросы',
        'gallery' => 'Галерея',
        'photos' => 'Фотографии',
        'login' => 'Авторизация',
        'logout' => 'Выход',
        'permissions' => 'Права доступа',
        'users' => 'Сотрудники',
        'roles' => 'Роли',
        'admin' => 'Администрирование',
    ],
    'message' => [
        'model_not_found' => 'Объект не найден',
        'empty_section' => 'В разделе нет ифнормации',
    ],

    'post' => [
        'title' => [
            'archive' => 'Архив новостей',
            'latest' => 'Последние новости',
            'edit' => 'Редактирование новости',
        ],
        'field' => [
            'title' => 'Заголовок',
            'created_at' => 'Опубликовано',
            'event_at' => 'Дата события',
            'text' => 'Текст',
            'image' => 'Изображение',
            'type' => 'Тип',
            'photo_categories' => 'Прикрепленная галерея',
            'polls' => 'Голосование',
            'is_pinned' => 'Закреплена',
        ],
        'button' => [
            'save' => 'Сохранить',
            'attend' => 'Хочу принять участие',
        ],
        'label' => [
            'event' => 'Событие',
            'event_with_date' => 'Событие | :date',
            'past_event' => 'Прошедшее событие',
            'news' => 'Новость',
            'total_members' => 'Участников',
            'members' => 'Участники',
        ],
    ],
    'gallery' => [
        'field' => [
            'title' => 'Название',
        ],
        'label' => [
            'total_photos' => 'Фотографий',
        ],
    ],
    'photo' => [
        'field' => [
            'caption' => 'Название',
            'description' => 'Описание',
            'created_at' => 'Загружена',
            'image' => 'Фото',
            'thumb' => 'Превью',
            'category' => 'Альбом',
        ],
    ],
    'poll' => [
        'label' => [
            'total_votes' => 'Всего голосов',
        ],
        'field' => [
            'title' => 'Заголовок',
            'total_votes' => 'Всего голосов',
            'description' => 'Описание',
            'answers' => 'Ответы',
            'expired_at' => 'Период действия',
        ],
        'button' => [
            'vote' => 'Голосовать',
            'reset' => 'Сбросить',
        ],
    ],
    'user' => [
        'label' => [
            'remember' => 'Запомнить меня',
            'since' => 'Зарегестрирован :date',
        ],
        'title' => [
            'contacts' => 'Контакты'
        ],
        'field' => [
            'username' => 'Имя',
            'email' => 'Email адрес',
            'password' => 'Пароль',
            'avatar' => 'Фото',
            'roles' => 'Роли',
            'phone_internal' => 'Внутренний',
            'phone_mobile' => 'Мобильный'
        ],
        'button' => [
            'login' => 'Войти',
            'logout' => 'Выход',
        ],
        'message' => [
            'drag_to_upload' => 'Перетащи сюда изображение для загрузки аватара'
        ]
    ],
];