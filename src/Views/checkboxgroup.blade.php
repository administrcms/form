<label for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
@foreach($field->checkboxes() as $checkbox)
    <label class="checkbox-inline">{!! $checkbox->render() !!}</label>
@endforeach
<span>{{ $errors->first($field->getName()) }}</span>