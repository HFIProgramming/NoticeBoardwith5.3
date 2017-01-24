

@foreach($votes as $vote)
    <h1>title{{$vote->title}}</h1>
    <p>简介：{{empty($vote->intro) ? '暂不可用' : $vote->intro}}</p>
    <p>结束时间：{{$vote->ended_at}}</p>   <!--结束时间客户端要学会自己判断-->
    <p>投票人数：{{count(explode("|", $vote->voted_user))-1}}</p>
@endforeach