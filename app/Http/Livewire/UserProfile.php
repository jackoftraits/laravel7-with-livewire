<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\User;

class UserProfile extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password;

    public $current_hashed_password;
    public $current_password_for_email;
    public $current_password_for_password;
    public $password_confirmation;

    public $prevName;
    public $prevEmail;
    
    public function mount()
    {
        $this->userId = auth()->user()->id;
        $model = User::find($this->userId);
        $this->name = $model->name;
        $this->email = $model->email;

        $this->prevName = $model->name;
        $this->prevEmail = $model->email;
        $this->current_hashed_password = $model->password;
    }

    public function hydrate()
    {
        // This is always the case
        $validateData = [
            'email' => 'email'
        ];

        // Just add validation if there are any changes in the fields
        if ($this->name !== $this->prevName) {
            if (empty($this->name)) {
                $validateData = array_merge($validateData, [
                    'name' => 'required'
                ]);
            }
        }

        if ($this->email !== $this->prevEmail) {
            if (empty($this->email)) {
                $validateData = array_merge($validateData, [
                    'email' => 'required|email'
                ]);
            }

            $validateData = array_merge($validateData, [
                'current_password_for_email' => ['required', 'customPassCheckHashed:'.$this->current_hashed_password]
            ]);
        }

        if (!empty($this->password)) {
            $validateData = array_merge($validateData, [
                'current_password_for_password' => ['required', 'customPassCheckHashed:'.$this->current_hashed_password] ,
                'password' => 'confirmed|min:6',
                'password_confirmation' => 'required'
            ]);
        }

        $this->validate($validateData);
    }

    public function save()
    {
        $data = [];

        // We will check if there are any changes in the fields
        if ($this->name !== $this->prevName) {
            $data = array_merge($data, ['name' => $this->name]);
        }

        if ($this->email !== $this->prevEmail) {
            $data = array_merge($data, ['email' => $this->email]);
        }

        if (!empty($this->password)) {
            $data = array_merge($data, ['password' => Hash::make($this->password)]);
        }

        if(count($data)) {
            User::find($this->userId)->update($data);
            return redirect()->to('/profile');
        }
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
