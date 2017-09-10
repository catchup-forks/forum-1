<ul class="list-group">
    @foreach($channels as $channel)
        <li class="list-group-item">
            <a href="/{{ $channel->slug }}">{{ $channel->name }}</a>
        </li>
    @endforeach
</ul>