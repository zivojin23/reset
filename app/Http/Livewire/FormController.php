<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Form;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class FormController extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $project_name;
    public $project_priority = '';
    public $project_status = '';
    public $project_person;
    public $attachment;

    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'project_name' => 'required',
        'project_priority' => 'required',
        'project_status' => 'required',
        'project_person' => 'required|email',
        'attachment' => 'required',
        
    ];

    public function store()
    {

        if (Auth::user()) {
            
            $this->first_name = Auth::user()->first_name;
            $this->last_name = Auth::user()->last_name;
            $this->email = Auth::user()->email;
        }

        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'project_name' => 'required',
            'project_priority' => 'required',
            'project_status' => 'required',
            'project_person' => 'required|email',

        ]);

        Form::create([
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'email'             => $this->email,
            'project_name'      => $this->project_name,
            'project_priority'  => $this->project_priority,
            'project_status'    => $this->project_status,
            'project_person'    => $this->project_person,
            'attachment'        => $this->attachment->store('public/docs')
 
        ]);

        session()->flash('submitted', 'Submitted!');

        $this->reset(['first_name','last_name','email', 'project_name', 'project_priority', 'project_status', 'project_person', 'attachment']);


    }   


    public function render()
    {
        return view('livewire.form-controller');
    }
}
