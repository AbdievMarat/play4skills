$(() => {
    $(document).on('click', '.detail', function (e) {
        e.preventDefault();

        const user_id = $(this).data('user_id');
        const csrf_token = $('meta[name="csrf-token"]').attr('content');

        $('#rating-detail-container').html('');

        $.ajax({
            type: 'GET',
            url: '/rating/' + user_id,
            headers: {'X-CSRF-TOKEN': csrf_token},
        }).done(successResponse => {
            $('#rating-detail-container').html(successResponse.modal_content);
            $("#modal-rating-detail").modal('show');
        }).fail(errorResponse => {
            alert('Ошибка при выполнении запроса: ' + errorResponse.status + ' ' + errorResponse.statusText + ' ' + JSON.stringify(JSON.parse(errorResponse.responseText), null, 4));
        });
    });
});
