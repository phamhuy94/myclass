$(document).ready(function () {
    //Init add comment event
    $('#btnComment').click(function () {
        var name = $.trim($('#txtName').val().toLowerCase());
        var content = $('#txtComment').val();
        var avatar = name.charAt(0);
        $('#list').append('<div class="item">' +
            '   <div class="avatar ' + avatar + '"></div>' +
            '   <div class="content">' +
            '       <p>' + $('#txtName').val() + '</p>' +
            '       <p>' + content + '</p>' +
            '   </div>' +
            '</div>');

        //reset field
        $('#txtName').val('');
        $('#txtComment').val('');
    });
});
