$(() => {
    $(document).on('click', '.get-mentor-users', function (e) {
        e.preventDefault();

        const mentor_id = $(this).data('mentor_id');
        const csrf_token = $('meta[name="csrf-token"]').attr('content');

        $('#rating-detail-container').html('');

        $.ajax({
            type: 'GET',
            url: '/rating_mentor_users/' + mentor_id,
            headers: {'X-CSRF-TOKEN': csrf_token},
        }).done(successResponse => {
            $(`#mentor-users-container-${mentor_id}`).html(successResponse.content);
        }).fail(errorResponse => {
            alert('Ошибка при выполнении запроса: ' + errorResponse.status + ' ' + errorResponse.statusText + ' ' + JSON.stringify(JSON.parse(errorResponse.responseText), null, 4));
        });
    });

    $(document).on('click', '.points-detail', function (e) {
        e.preventDefault();

        const user_id = $(this).data('user_id');
        const csrf_token = $('meta[name="csrf-token"]').attr('content');

        $('#rating-detail-container').html('');

        $.ajax({
            type: 'GET',
            url: '/rating_points_detail/' + user_id,
            headers: {'X-CSRF-TOKEN': csrf_token},
        }).done(successResponse => {
            $('#points-detail-container').html(successResponse.modal_content);
            $("#points-detail-modal").modal('show');
        }).fail(errorResponse => {
            alert('Ошибка при выполнении запроса: ' + errorResponse.status + ' ' + errorResponse.statusText + ' ' + JSON.stringify(JSON.parse(errorResponse.responseText), null, 4));
        });
    });

});
