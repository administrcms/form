<label for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
<textarea id="{{ $field->getName() }}" name="{{ $field->getName() }}" {!! $field->attributes() !!}>
    {!! $field->getValue() !!}
</textarea>
<span>{{ $errors->first($field->getName()) }}</span>