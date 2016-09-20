<label for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
<select id="{{ $field->getName() }}" name="{{ $field->getName() }}" {!! $field->attributes() !!}>
    @foreach($field->options() as $option)
        {!! $option->render() !!}
    @endforeach
</select>
<span>{{ $errors->first($field->getName()) }}</span>