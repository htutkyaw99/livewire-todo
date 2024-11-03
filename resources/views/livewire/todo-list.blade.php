<div>
    @include('includes.input')
    @include('includes.search-box')
    <div id="todos-list">
        @foreach ($todos as $todo)
            @include('includes.todo-card')
        @endforeach

        <div class="my-2">
            {{ $todos->links() }}
        </div>
    </div>
</div>
