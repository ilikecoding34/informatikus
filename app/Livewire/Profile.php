<?php

namespace App\Livewire;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Profile extends Component
{
    // Profile data
    public $name = '';
    public $email = '';
    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';

    // Layout settings
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
        $this->name = $user->name;
        $this->email = $user->email;

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

    public function saveProfile()
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ];
        if ($this->password) {
            $rules['current_password'] = ['required', 'string'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $data = $this->validate($rules);

        if (!empty($this->password)) {
            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'A jelenlegi jelszó nem megfelelő.');
                return;
            }
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($this->password)) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetErrorBag();
        session()->flash('profile_message', 'Személyes adatok mentve.');
    }

    public function saveLayout()
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
        $this->resetErrorBag();
        session()->flash('layout_message', 'Főoldal elrendezése mentve.');
    }

    public function render()
    {
        return view('livewire.profile', [
            'sidebarOptions' => config('sidebar.options', []),
        ]);
    }
}
