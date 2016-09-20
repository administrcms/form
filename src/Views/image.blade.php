<label for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
<img src="{{ $field->getSrc() }}" class="administr_image_type">
<input {!! $field->attributes() !!} id="{{ $filed->getName() }}" name="{{ $field->getName() }}" value="{{ $field->getValue() }}">
<span>{{ $errors->first($field->getName()) }}</span>