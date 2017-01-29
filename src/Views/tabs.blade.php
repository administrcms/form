@foreach ($tabs as $tab)
    {{ $tab }}
@endforeach

@foreach ($contents as $key => $content)
    {!! $content->render() !!}
@endforeach