<div class="language">
<select class="language-selector" data-endpoint="{{ route('change_language') }}">
	@foreach($languages as $language)
	<option value="{{ $language->label }}" {{ $language->label == app()->getLocale() ? 'selected' : '' }}>{{ $language->name }}</option>
	@endforeach
</select>
</div>