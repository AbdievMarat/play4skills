<script src="https://cdn.tiny.cloud/1/o2lw76h4rzzn1uini6b88gvcdtl44mluu5xxtr0yhtbspkrb/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#tinymce-editor',
        plugins: 'table lists link',
        toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | link'
    });
</script>

<label for="tinymce-editor" class="form-label">{{ $label }}</label>

<textarea name="{{ $name }}" id="tinymce-editor" class="@error($name) is-invalid @enderror">{!! $value !!}</textarea>

@error($name)
<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
@enderror
