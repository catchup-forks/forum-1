<ul class="list-group">
    @foreach($latestThreads as $thread)
        <li class="list-group-item">
            <a href="{{ $thread->path() }}">
                {{ $thread->title }}
            </a>
        </li>
    @endforeach
</ul>