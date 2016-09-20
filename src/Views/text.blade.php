<label for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
<input {!! $field->attributes() !!} id="{{ $field->getName() }}" name="{{ $field->getName() }}" value="{{ $field->getValue() }}">
<span>{{ $errors->first($field->getName()) }}</span>