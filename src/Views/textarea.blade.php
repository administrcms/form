<label for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
<textarea id="{{ $filed->getName() }}" name="{{ $field->getName() }}" {!! $field->attributes() !!}>
    {!! $field->getValue() !!}
</textarea>
<span>{{ $errors->first($field->getName()) }}</span>