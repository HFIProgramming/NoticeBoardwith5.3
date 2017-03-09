<!-- Vote Question Block: Copy this block for multi-questions -->
<div class="vote-block">
    <p class="flow-text">{{$question->content}}</p>
    <br>
    <div class="vote-info">
        <div>{{$question->explanation}}</div>
        <br>
        @if ($question->range > 1)
            @foreach($question->options as $option)
                <p>
                    <input ty   pe="checkbox" class="filled-in" id="vote-item-{{$option->id}}"/>
                    <label for="vote-item-{{$option->id}}">{{$option->content}}</label>
                </p>
            @endforeach
        @else
            @foreach($question->options as $option)
                <p>
                    <input class="with-gap" name="group{{$question->id}}" type="radio" id="vote-item-{{$option->id}}"/>
                    <label for="vote-item-{{$option->id}}">{{$option->content}}</label>
                </p>
            @endforeach
        @endif
    </div>
</div>
<!--End Vote Question Block-->