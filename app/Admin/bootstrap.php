<?php

PackageManager::add('front.libs')
    ->js('settings', asset('api/settings.js'))
    ->js(null, asset('js/all.js'))
    ->css(null, asset('css/app.css'));

PackageManager::add('front.controllers')
    ->js(null, asset('js/controllers.js'));

PackageManager::add('fullcalendar')
    ->js(null, asset('libs/fullcalendar/js/fullcalendar.min.js'), 'front.libs')
    ->css(null, asset('libs/fullcalendar/css/fullcalendar.min.css'));

PackageManager::add('filterTable')
    ->js(null, asset('libs/jquery.filtertable/js/jquery.filtertable.js'), 'front.libs');