<label for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
<input {!! $field->attributes() !!} id="{{ $filed->getName() }}" name="{{ $field->getName() }}" value="{{ $field->getValue() }}">
<span>{{ $errors->first($field->getName()) }}</span>