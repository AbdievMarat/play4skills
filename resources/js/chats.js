$(() => {
    $(document).on('click', '.chat', function (e) {
        e.preventDefault();

        const user_id_from = $(this).data('user_id_from');

        chat_content_show(user_id_from);
    });

    $(document).on('click', '#file-upload', function (e) {
        e.preventDefault();

        $('#file-input').click();
    });

    $(document).on('change', '#file-input', function () {
        $('#chat-store').find('[name="is_file"]').val(1);

        submitting_chat_form();
    });

    $(document).on('click', '#submit-chat', function (e) {
        e.preventDefault();

        $('#chat-store').find('[name="is_file"]').val(0);

        submitting_chat_form();
    });

    function chat_content_show(user_id_from) {
        const csrf_token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'GET',
            url: '/chats/' + user_id_from,
            headers: {'X-CSRF-TOKEN': csrf_token},
        }).done(successResponse => {
            $('#chat-container').html(successResponse.chat_content);

            $('#chat-store').find('[name="user_id_from"]').val(user_id_from);
            $(`.number-of-unread[data-user_id_from="${user_id_from}"]`).addClass('d-none');
        }).fail(errorResponse => {
            alert('Ошибка при выполнении запроса: ' + errorResponse.status + ' ' + errorResponse.statusText + ' ' + JSON.stringify(JSON.parse(errorResponse.responseText), null, 4));
        });
    }

    function submitting_chat_form() {
        const csrf_token = $('meta[name="csrf-token"]').attr('content');
        const formData = new FormData($('#chat-store')[0]);

        $('.chat-errors').remove();

        $.ajax({
            type: 'POST',
            url: '/chats',
            data: formData,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': csrf_token},
            success: function () {
                const user_id_from = $('#chat-store').find('[name="user_id_from"]').val();

                chat_content_show(user_id_from);

                if ($('#chat-store').find('[name="is_file"]').val() === '0') {
                    $('#chat-store').find('[name="content"]').val('');
                }
            },
            error: function (errorResponse) {
                if (errorResponse.status === 422) {
                    const response = JSON.parse(errorResponse.responseText);

                    if (response.errors) {
                        for (let field in response.errors) {
                            $('#errors').after(`<span class="invalid-feedback chat-errors" role="alert"><strong>${response.errors[field][0]}</strong></span>`);
                        }
                    }
                } else {
                    alert('Ошибка при выполнении запроса: ' + errorResponse.status + ' ' + errorResponse.statusText + ' ' + JSON.stringify(JSON.parse(errorResponse.responseText), null, 4));
                }
            }
        });
    }
});
