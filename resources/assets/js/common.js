var Asset = {
    path: function(path) {
        if (path.charAt(0) === '/')
            path = path.slice(1);

        return window.settings.asset_url + path;
    }
}

var User = {
    _object: null,
    init: function(user) {
        this._object = user;
    },
    getId: function() {
        return this._object.id || null;
    },
    getObject: function () {
        return this._object;
    },
    isLoggedIn: function() {
        return _.has(this._object, "id");
    }
}

User.init(window.settings.user);
Dropzone.autoDiscover = false;

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.image-link').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });

    $('.dropdown').dropdown();
    $('.popup').popup();

    $('.searchable').filterTable({
        label: '<i class="search icon"></i>',
        containerTag: 'div',
        placeholder: 'Введите слово для поиска',
        containerClass: 'ui large fluid icon input input-search'
    });
});