@extends('layouts.app')

@section('title','Vote Ticket Status')

@section('content')
    <div class="post-card">
        <div class="card white lighten-2 no-shadow" style="border-radius: 0">
            <div class="card-content">
                <h6>工具栏</h6>
            </div>
            <div class="card-action">
                <div class="btn waves-effect waves-light red no-shadow white-text" onclick="toggle_confirmation('none','/admin/vote/ticket/activate/')">全部禁用</div>
                <div class="btn waves-effect waves-light purple no-shadow white-text" onclick="toggle_confirmation('all','/admin/vote/ticket/activate/')">全部激活</div>
                <div class="btn waves-effect waves-light green no-shadow white-text" onclick="location.href=''">刷新本页</div>
            </div>
        </div>
    </div>
    
    <form action="" method="post" accept-charset="utf-8">
    <div class="post-card">
        <div class="card white lighten-2 no-shadow" style="border-radius: 0">
            <div class="card-content">
                <h6>查找Ticket根据Id</h6>
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" id="ticket-search" name="ticketid" class="validate">
                        <label for="ticket-search">Search on Ticket ID</label>
                    </div>
                </div>
            </div>
            <div class="card-action">
                <button class="btn waves-effect waves-light blue no-shadow" type="submit">搜索</button>
            </div>
        </div>
    </div>
    </form>

    <form id="ticket-range-form" action="/admin/vote/ticket/toggle/with/range" method="post" accept-charset="utf-8">
    <div class="post-card">
        <div class="card white lighten-2 no-shadow" style="border-radius: 0">
            <div class="card-content">
                {{ csrf_field() }}
                <h6>范围内Ticket状态更变</h6>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="number" id="ticket-range-start" name="startIndex" class="validate">
                        <label for="ticket-search">From id</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="number" id="ticket-range-end" name="endIndex" class="validate">
                        <label for="ticket-search">To Id (inclusive)</label>
                    </div>
                </div>
                <input type="hidden" name="action" id="ticket-range-action">
            </div>
            <div class="card-action">
                <p>
                    <input class="with-gap" name="ticket-range" type="radio" id="ticket-range-activate" onclick="setRangeStatus(this.id)" />
                    <label for="ticket-range-activate">激活范围内的Ticket</label>
                </p>
                <p>
                    <input class="with-gap" name="ticket-range" type="radio" id="ticket-range-disable" onclick="setRangeStatus(this.id)" />
                    <label for="ticket-range-disable">禁用范围内的Ticket</label>
                </p>
                <button class="btn waves-effect waves-light blue no-shadow" type="submit">执行</button>
            </div>
        </div>
    </div>
    </form>

    <div class="post-card">
        <div class="card-panel white lighten-2 no-shadow" style="border-radius: 0">
            <table class="centered striped responsive-table">
                <thead>
                    <tr>
                        <th data-field="Name">ID</th>
                        <th data-field="Name">键值</th>
                        <th data-field="Name">激活状态</th>
                        <th data-field="Name">投票记录</th>
                        <th data-field="Name">清空投票</th>
                        <th data-field="Name">激活开关</th>
                    </tr>
                </thead>
                
                <tbody>
                @foreach($ticket as $ticket)
                    <tr>
                        <td>{{$ticket->id}}</td>
                        <td>{{$ticket->string}}</td>
                        <td>{{($ticket->active) ? '是' : '否'}}</td>
                        <td><?php foreach($ticket->usedForVote() as $voteid){ echo $voteid.', ';}?></td>
                        <td>
                            <button class="btn waves-effect waves-light pink no-shadow" onclick="toggle_confirmation({{$ticket->id}},'/admin/vote/ticket/clearallvote/')">清空</button>
                        </td>
                        <td>
                            <button class="btn waves-effect waves-light orange no-shadow" onclick="toggle_confirmation({{$ticket->id}}, '/admin/vote/ticket/toggle/')">{{($ticket->active) ? '禁用' : '启用'}}</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $("#ticket-range-form").submit(function(e){
        if($("#ticket-range-start").val() == "" || $("#ticket-range-end").val() == "" || $("#ticket-range-action").val() == ""){
            alert("请填写完范围与操作类型");
            e.preventDefault();
        }
    })

    function setRangeStatus(id){
        switch(id){
            case "ticket-range-activate":
                $("#ticket-range-action").val("activate");
                break;
            case "ticket-range-disable":
                $("#ticket-range-action").val("disable");
                break;
        }
    }

    function toggle_confirmation(id, url){
        if(confirm("Are you sure to change ticket status?")){
            location.href = url + id;
        }
    }
</script>
@endsection