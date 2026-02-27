<?php

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Tags extends Component
{
    public $name = '';
    public $editId = null;
    public $editName = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'editName' => 'required|string|max:255',
        ];
    }

    protected $validationAttributes = [
        'name' => 'tag név',
        'editName' => 'tag név',
    ];

    public function save()
    {
        $this->validateOnly('name');
        Tag::create(['name' => $this->name]);
        $this->name = '';
        session()->flash('message', 'Tag létrehozva.');
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $this->editId = $tag->id;
        $this->editName = $tag->name;
    }

    public function update()
    {
        $this->validateOnly('editName');
        $tag = Tag::findOrFail($this->editId);
        $tag->update(['name' => $this->editName]);
        $this->cancelEdit();
        session()->flash('message', 'Tag frissítve.');
    }

    public function cancelEdit()
    {
        $this->editId = null;
        $this->editName = '';
        $this->resetValidation('editName');
    }

    public function delete($id)
    {
        Tag::findOrFail($id)->delete();
        if ($this->editId == $id) {
            $this->cancelEdit();
        }
        session()->flash('message', 'Tag törölve.');
    }

    public function render()
    {
        return view('livewire.tags', [
            'tags' => Tag::withCount('posts')->orderBy('name')->get(),
        ]);
    }
}

