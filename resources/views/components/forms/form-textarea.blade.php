

    <div class="form-group {{$row}}">
        <label for="{{$id}}">{{$title}}</label>
        <textarea class="form-control @error('{{$id}}') is-invalid @enderror" id="{{$id}}" id="{{$id}}" name="{{$id}}" rows="3">{{$value}}</textarea>
    </div>
