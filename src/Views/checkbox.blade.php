<label for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
<input type="checkbox" id="{{ $filed->getName() }}" name="{{ $field->getName() }}" value="{{ $field->getValue() }}" {!! $field->attributes() !!}>
<span>{{ $errors->first($field->getName()) }}</span>