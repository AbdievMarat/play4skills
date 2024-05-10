<div class="input-group">
    <select
        form="{{ $form }}"
        name="{{ $name }}"
        class="form-select"
    >
        @if($options)
            <option value=""></option>
        @endif

        @forelse($options as $key => $option)
            <option value="{{ $key }}" @selected($key == $value)>{{ $option }}</option>
        @empty
            {{ $slot }}
        @endforelse
    </select>
    <button data-name="{{ $name }}" class="btn btn-outline-danger clean-input">
        <i class="bi bi-x-lg"></i>
    </button>
</div>
