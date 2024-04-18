$(() => {
    $(document).on('blur change', '*[form="search"]', function () {
        if($(this).val() !== ''){
            $('#search').submit();
        }
    });

    $(document).on('click', '.clean-input', function () {
        const name = $(this).data('name');
        $(`[name=${name}]`).val('');

        $('#search').submit();
    });

    $(document).on('click', '.delete-entry', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: 'Вы уверены?',
            text: "Вы не сможете восстановить данные!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#107ee1',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Да, удалить!',
            cancelButtonText: 'Отмена!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('.single-select').select2({
        multiple: false,
        placeholder: "Выберите варианты",
        theme: 'bootstrap-5',
    });

    $('.multiple-select').select2({
        closeOnSelect: false,
        multiple: true,
        placeholder: "Выберите варианты",
        theme: 'bootstrap-5',
    });

    $(document).on('click', '.dropdown-toggle-custom', function () {
        const $this = $(this);
        const dropdownMenu = $this.next('.dropdown-menu');
        const isOpen = $this.attr('aria-expanded') === 'true';

        if (!isOpen) {
            $this.addClass('show');
            dropdownMenu.addClass('show');
            $this.attr('aria-expanded', 'true');
        } else {
            $this.removeClass('show');
            dropdownMenu.removeClass('show');
            $this.attr('aria-expanded', 'false');
        }
    });
});
