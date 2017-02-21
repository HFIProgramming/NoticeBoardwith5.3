<div class="post-card">
    <div class="card vertical post-card-content">
        <div class="card-content display-all">
            <br>
            <p class="flow-text">{{$question->content}}</p>
            <br>
            <div class="vote-info">
                @if ($question->range > 1)
                    @foreach($question->options as $option)
                        <p>
                            <input type="checkbox" id="{{$option->id}}"/>
                            <label for="{{$option->id}}">{{$option->content}}</label>
                        </p>
                    @endforeach
                @else
                    @foreach($question->options as $option)
                        <p>
                            <input class="with-gap" name="{{$question->id}}" type="radio" id="{{$option->id}}"/>
                            <label for="{{$option->id}}">{{$option->content}}</label>
                        </p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>