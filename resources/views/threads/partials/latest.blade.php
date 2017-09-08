<ul class="list-group">
    @foreach($threads as $thread)
        <li class="list-group-item">
            <a href="{{ $thread->path() }}">
                {{ $thread->title }}
            </a>
        </li>
    @endforeach
</ul>