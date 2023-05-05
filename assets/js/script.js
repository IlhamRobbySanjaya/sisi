$(function () {
    $('.editmenu').on('click', function () {
        $('#modallabel').html('ubah data menu');
        $('.modal-footer button[type=submit]').html('update');

        const id = $(this).data('id');


        $.ajax({
            url: "http://localhost/sisi/menu/getubah",
            data: {
                id: id
            },
            method: "post",
            dataType: "json",
            success: function (data) {
                console.log(data);
            }
        });
    });

    $('.tambahmenu').on('click', function () {
        $('#modallabel').html('add data menu');
        $('.modal-footer button[type=submit]').html('add');
    });
});