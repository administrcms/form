<label for="{{ $field->getName() }}">{{ $field->getLabel() }}</label>
@foreach($field->radios() as $radio)
    <label class="radio-inline">{!! $radio->render() !!}</label>
@endforeach
<span>{{ $errors->first($field->getName()) }}</span>