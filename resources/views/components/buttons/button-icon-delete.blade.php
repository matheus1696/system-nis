
    <form action="{{$route}}" method="post">
        @method('DELETE') @csrf
        <button type="submit" class="text-danger btn btn-sm"><i class="fas fa-trash"></i></button>
    </form>