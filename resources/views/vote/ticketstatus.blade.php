@extends('layouts.app')

@section('title','Vote Ticket Status')

@section('content')
    <div class="post-card" style="margin-bottom:0;">
        <div class="card-panel red lighten-2 no-shadow" style="margin: 0;border-radius: 0">
            <div class="white-text">
                <div style="display:inline-block;line-height: 2rem; height: 2rem; position: relative; top: 0.2rem"><i class="material-icons">error</i></div>
                <h5 style="display: inline-block;line-height: 2rem; height: 2rem;">Read Me</h5>
                <div>
                    该面板默认显示所有Ticket<br>
                    <li>你也可以通过id搜索单张ticket</li>
                    除此之外，你还可以:
                    <li>激活所有Ticket</li>
                    <li>点击“刷新本页”按钮查看所有Ticket</li>
                    <li>清空某张Ticket的所有投票记录</li>
                    <li>激活／禁用某张Ticket</li>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" accept-charset="utf-8">
    <div class="post-card">
        <div class="card white lighten-2 no-shadow" style="border-radius: 0">
            <div class="card-content">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" id="ticket-search" name="ticketid" class="validate">
                        <label for="ticket-search">Search on Ticket ID</label>
                    </div>
                </div>
            </div>
            <div class="card-action">
                <div class="btn waves-effect waves-light purple no-shadow white-text" onclick="location.href='/admin/vote/ticket/activate/all'">全部激活</div>
                <div class="btn waves-effect waves-light green no-shadow white-text" onclick="location.href=''">刷新本页</div>
                <button class="btn waves-effect waves-light blue no-shadow" type="submit">搜索</button>
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
    function toggle_confirmation(id, url){
        if(confirm("Are you sure to change ticket status?")){
            location.href = url + id;
        }
    }
</script>
@endsection