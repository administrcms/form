<optgroup label="{{ $field->getLabel() }}">
    @foreach($field->options() as $option)
        {!! $option->render() !!}
    @endforeach
</optgroup>