@props(['languages'])
<div class="tabs tabs--lang">
	<select name="language" id="language">
		@foreach ($languages as $language)
			<option value="{{ $language->label }}" {{ $language->label == app()->getLocale() ? 'selected' : '' }}>{{ $language->label }}</option>
		@endforeach
	</select>
</div>