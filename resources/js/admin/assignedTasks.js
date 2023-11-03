$(() => {
    $(document).on('click', '.accept', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: 'Принять задачу',
            text: 'Введите бонус',
            input: 'number',
            inputValue: 0, // Значение по умолчанию
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Принять',
            showLoaderOnConfirm: true,
            preConfirm: (bonus) => {
                form.append(`<input type="hidden" name="bonus" value="${bonus}">`);
                form.submit();
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    });

    $(document).on('click', '.revision', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: 'Отправить на доработку',
            text: 'Введите комментарий',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Отправить',
            showLoaderOnConfirm: true,
            preConfirm: (comment_moderator) => {
                form.append(`<input type="hidden" name="comment_moderator" value="${comment_moderator}">`);
                form.submit();
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    });

    $(document).on('click', '.under-review', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: 'Завершить задачу?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#107ee1',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Да!',
            cancelButtonText: 'Отмена!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
