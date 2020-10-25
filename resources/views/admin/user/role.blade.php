<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
@include('admin.common.validate')

<form action="{{ route('admin.user.role',$user) }}" method="post">
    @csrf

    @foreach($roleAll as $item)
        <div>
            <label>{{ $item->name }}
                <input type="radio" name="role_id" value="{{ $item->id }}"
                @if($item->id == $user->role_id) checked @endif
                >
            </label>
        </div>
    @endforeach

    <button type="submit">给用户指定角色</button>

</form>
</body>
</html>
