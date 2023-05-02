@if (isset($errors) && count($errors) > 0)
    <div class="bg-red-100 border border-red-400 text-red-700 mt-2 px-4 py-3 rounded relative" role="alert">
        <ul>
            @foreach ($errors as $key => $array)
                @foreach ($array as $key => $message)
                    <li>{{ $message }}</li>
                @endforeach
            @endforeach
        </ul>
    </div>
@endif

