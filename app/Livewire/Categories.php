<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Categories extends Component
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
        'name' => 'kategória név',
        'editName' => 'kategória név',
    ];

    public function save()
    {
        $this->validateOnly('name');
        Category::create(['name' => $this->name]);
        $this->name = '';
        session()->flash('message', 'Kategória létrehozva.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->editId = $category->id;
        $this->editName = $category->name;
    }

    public function update()
    {
        $this->validateOnly('editName');
        $category = Category::findOrFail($this->editId);
        $category->update(['name' => $this->editName]);
        $this->cancelEdit();
        session()->flash('message', 'Kategória frissítve.');
    }

    public function cancelEdit()
    {
        $this->editId = null;
        $this->editName = '';
        $this->resetValidation('editName');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if ($category->posts()->exists()) {
            session()->flash('error', 'Nem törölhető: van hozzá rendelt bejegyzés. Előbb módosítsd a bejegyzések kategóriáját.');
            return;
        }
        $category->delete();
        if ($this->editId == $id) {
            $this->cancelEdit();
        }
        session()->flash('message', 'Kategória törölve.');
    }

    public function render()
    {
        return view('livewire.categories', [
            'categories' => Category::withCount('posts')->orderBy('name')->get(),
        ]);
    }
}
