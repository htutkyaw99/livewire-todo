<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{

    use WithPagination;

    #[Rule('required|min:3|max:50')]
    public $name;

    public $search;

    public $editId;

    #[Rule('required|min:3|max:50')]
    public $editName;

    public function create()
    {
        $validated = $this->validateOnly('name');

        Todo::create($validated);

        $this->reset('name');

        $this->resetPage();

        session()->flash('success', 'Saved.');
    }

    public function delete(Todo $todo)
    {
        $todo->delete();
    }

    public function toggle(Todo $todo)
    {
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function edit(Todo $todo)
    {
        $this->editId = $todo->id;
        $this->editName = $todo->name;
    }

    public function cancel()
    {
        $this->reset('editId', 'editName');
    }

    public function update(Todo $todo)
    {
        $this->validateOnly('editName');
        $todo->name = $this->editName;
        $todo->save();
        $this->cancel();
    }

    public function render()
    {

        return view(
            'livewire.todo-list',
            [
                'todos' => Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5)
            ]
        );
    }
}
