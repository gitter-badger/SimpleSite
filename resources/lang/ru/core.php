<?php

return [
    'title' => [
        'portal' => 'Корпоративный портал Инфозащита',
        'portal_calendar' => 'График мероприятий с портала Инфозащита',
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
        'calendar' => 'Календарь',
    ],
    'message' => [
        'model_not_found' => 'Объект не найден',
        'empty_section' => 'В разделе нет ифнормации',
        'copyright' => 'АО «Инфозащита» © '.date('Y'),
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
            'link_to_event' => 'Ссылка на событие: :link',
        ],
    ],
    'gallery' => [
        'field' => [
            'title' => 'Название',
            'created_at' => 'Дата создания',
            'description' => 'Описание',
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
            'birthday' => 'День рождения',
            'nearest_birthdays' => 'Ближайшие дни рождения',
            'birthday_today' => 'Сегодня',
        ],
        'link' => [
            'profile' => 'Профиль',
            'admin' => 'Администрирование',
            'login' => 'Вход',
            'logout' => 'Выход',
        ],
        'title' => [
            'contacts' => 'Контакты',
            'events' => 'Участник событий',
            'calendar' => 'Календарь',
        ],
        'field' => [
            'username' => 'Имя',
            'email' => 'Email адрес',
            'password' => 'Пароль',
            'avatar' => 'Фото',
            'roles' => 'Роли',
            'position' => 'Должность',
            'phone_internal' => 'Внутренний',
            'phone_mobile' => 'Мобильный',
            'birthday' => 'День рождения',
            'chief' => 'Руководитель',
        ],
        'button' => [
            'login' => 'Войти',
            'logout' => 'Выход',
        ],
        'message' => [
            'drag_to_upload' => 'Перетащи сюда изображение для загрузки аватара',
        ],
    ],
    'calendar' => [
        'field' => [
            'description' => 'Описание',
            'user' => 'Сотрудник',
            'start_at' => 'С',
            'end_at' => 'По',
            'type' => 'Тип',
        ],
        'type' => [
            \App\Calendar::TYPE_MISSED => 'Отсутсвие',
            \App\Calendar::TYPE_VACATION => 'Отпуск',
            \App\Calendar::TYPE_BUSINESS_TRIP => 'Командировка',
            \App\Calendar::TYPE_OTHER => 'Другое',
        ],
    ],
];