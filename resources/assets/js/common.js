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