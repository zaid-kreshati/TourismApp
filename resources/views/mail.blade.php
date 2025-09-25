{{-- Here Is the body from controller --}}
{{ $data['body'] }}


@if ($data['date'])
    <p style="text-decoration:underline; text-wrap: balance;  margin-top:10px; color:rgb(13, 47, 236); ">{{$data['date']}}</p>
@endif

<p style="text-decoration:underline; margin-top:10px; color:rgb(13, 47, 236); ">{{ $data['time'] }}</p>
<p style="color: rgb(86, 90, 95); font-weight:bold">Thanks, Enjoy!</p>

