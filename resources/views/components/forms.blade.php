
<div class="form-group {{$row}}">
    <label for="{{$id}}">{{$title}}</label>
    <input type="{{$type}}" class="form-control @error('{{$id}}') is-invalid @enderror" id="{{$id}}" name="{{$id}}" placeholder="{{$title}}" min="{{$min}}" minlength="{{$minlength}}" max="{{$max}}"  maxlength="{{$maxlength}}" value="{{$value}}" {{$required}}>
</div>
