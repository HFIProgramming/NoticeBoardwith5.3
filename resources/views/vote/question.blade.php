{{--Important!!!! This form will return all IDs of selected items in JSON in the name of "selected" !--}}
{{--选项id结构设置为"vote-item-{id}"，其中，{id}请改为改选项在数据库中的primary key 值--}}
<!-- Vote Question Block: Copy this block for multi-questions -->
<div class="vote-block">
    <p class="flow-text">{{$question->content}}</p>
    <br>
    <div class="vote-info">
        @if ($question->range > 1)
            @foreach($question->options as $option)
                <p>
                    <input type="checkbox" class="filled-in" id="vote-item-{{$option->id}}"/>
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