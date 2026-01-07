<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Profile extends Component
{
    // Properties for the form
    public $name;
    public $email;
    public $phone;
    
    // Toggle state
    public $isEditing = false;

    public function mount()
    {
        // Fill the form with current user data
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function toggleEdit()
    {
        // Switch between View and Edit mode
        $this->isEditing = !$this->isEditing;
        
        // If cancelling, reset data back to original
        if (!$this->isEditing) {
            $this->mount();
        }
    }

    public function save()
    {
        $user = Auth::user();

        // 1. Validate
        $this->validate([
            'name' => 'required|min:3',
            'phone' => 'required',
            // Email must be unique, but ignore the current user's own email
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        // 2. Update Database
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        // 3. Switch back to View Mode & Show Message
        $this->isEditing = false;
        session()->flash('message', 'Profile updated successfully!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.profile', [
            'user' => Auth::user()
        ]);
    }
}