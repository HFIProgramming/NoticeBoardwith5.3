@extends('layouts.app')

@section('title','Vote Ticket Status')

@section('content')
    <div class="post-card" style="margin-bottom:0;">
        <div class="card-panel red lighten-2 no-shadow" style="margin: 0;border-radius: 0">
            <div class="white-text">
                <div style="display:inline-block;line-height: 2rem; height: 2rem; position: relative; top: 0.2rem"><i class="material-icons">error</i></div>
                <h5 style="display: inline-block;line-height: 2rem; height: 2rem;">Read Me</h5>
                <div>
                    This page shows all un-activated tickets by default.<br>
                    You can also do a custom ticket search by id.
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
            <table class="centered striped">
                <thead>
                    <tr>
                        <th data-field="Name">ID</th>
                        <th data-field="Name">Ticket String</th>
                        <th data-field="Name">Active</th>
                        <th data-field="Name">Used for VoteID</th>
                        <th data-field="Name">Actions</th>
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
                            <button class="btn waves-effect waves-light orange no-shadow" onclick="toggle_confirmation({{$ticket->id}})">{{($ticket->active) ? '禁用' : '启用'}}</button>
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
    function toggle_confirmation(id){
        if(confirm("Are you sure to change ticket status?")){
            location.href = "/admin/vote/ticket/toggle/" + id;
        }
    }
</script>
@endsection