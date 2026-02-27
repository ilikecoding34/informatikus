<?php

namespace App\Livewire;

use App\Models\Setting;
use Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Pagesettings extends Component
{
    public $show_left_column = true;
    public $show_right_column = true;
    public $left_sidebar = 'newest';
    public $right_sidebar = 'most_viewed';

    public function mount()
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }
        $setting = Setting::firstOrCreate(
            ['user_id' => $user->id],
            [
                'show_left_column' => true,
                'show_right_column' => true,
                'left_sidebar' => 'newest',
                'right_sidebar' => 'most_viewed',
                'col_count' => 3,
                'col_post' => 2,
                'col_related' => null,
                'col_comment' => null,
            ]
        );
        $this->show_left_column = (bool) $setting->show_left_column;
        $this->show_right_column = (bool) $setting->show_right_column;
        $this->left_sidebar = $setting->left_sidebar ?? 'newest';
        $this->right_sidebar = $setting->right_sidebar ?? 'most_viewed';
        // If both had the same non-empty value (e.g. from before this rule), clear the right so the dropdowns stay valid
        if ($this->left_sidebar && $this->right_sidebar && $this->left_sidebar === $this->right_sidebar) {
            $this->right_sidebar = '';
        }
    }

    public function updatedLeftSidebar()
    {
        if ($this->left_sidebar && $this->right_sidebar === $this->left_sidebar) {
            $this->right_sidebar = '';
        }
    }

    public function updatedRightSidebar()
    {
        if ($this->right_sidebar && $this->left_sidebar === $this->right_sidebar) {
            $this->left_sidebar = '';
        }
    }

    public function save()
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $left = $this->left_sidebar ?: null;
        $right = $this->right_sidebar ?: null;
        if ($left && $right && $left === $right) {
            $this->addError('right_sidebar', 'A bal és a jobb oldali oszlop nem lehet ugyanaz. Válassz különböző tartalmat vagy „Nincs” az egyik oldalon.');
            return;
        }

        $showLeft = $left !== null && $left !== '';
        $showRight = $right !== null && $right !== '';

        Setting::updateOrCreate(
            ['user_id' => $user->id],
            [
                'show_left_column' => $showLeft,
                'show_right_column' => $showRight,
                'left_sidebar' => $left,
                'right_sidebar' => $right,
                'col_count' => 3,
                'col_post' => 2,
                'col_related' => null,
                'col_comment' => null,
            ]
        );
        session()->flash('message', 'Beállítások mentve. A főoldal elrendezése frissült.');
    }

    public function render()
    {
        return view('livewire.pagesettings', [
            'sidebarOptions' => config('sidebar.options', []),
        ]);
    }
}
