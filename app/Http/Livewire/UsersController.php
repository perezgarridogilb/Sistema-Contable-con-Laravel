<?php

namespace App\Http\Livewire;

use App\Models\User;
use Spatie\Permission\Models\Role;

use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Component;

class UsersController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $phone, $email, $status, $image, $password, $selected_id, $profile;
    public $pageTitle, $componentName, $searchTerm;
    private $pagination = 3;

public function paginationView() {
        return 'vendor.livewire.bootstrap';
}


public function mount() {
    $this->pageTitle = 'Listado';
    $this->componentName = 'Usuarios';
    $this->status = 'Elegir';
}
  

public function render()
    {
        if (strlen($this->searchTerm)>0) {
            $data = User::where('name', 'like', '%' . $this->searchTerm . '%')
            ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = User::select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        }
        return view('livewire.users.component', [
            'data' => $data,
            'roles' => Role::orderBy('name', 'asc')->get(),
        ])
        ->extends('layouts.theme.app')
        ->section('content');
}

public function searchProducts()
{
$this->resetPage(); // Reinicia la página de la paginación al realizar una nueva búsqueda
$this->render(); // Vuelve a renderizar el componente para aplicar la búsqueda
}


public function resetUI() {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->image = '';
        $this->searchTerm = '';
        $this->status = 'Elegir';

        $this->selected_id = 0;

        $this->resetValidation();
        $this->resetPage();
}

    public function edit(User $user) {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->password = '';
        
        $this->emit('show-modal', 'open!');
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'
    ];

    public function Store() {

        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'
        ];

        $messages = [
            'name.required' => 'Ingresa el nombre',
            'name.min' => 'El nombre del usuario debe tener al menos tres caracteres.',
            'email.required' => 'Ingresa el correo.',
            'email.email' => 'Ingresa un correo válido.',
            'email.unique' => 'El email ya existe en sistema.',
            'status.required' => 'Selecciona el estatus del usuario.',
            'status.not_in' => 'Selecciona el estatus.',
            'profile.required' => 'Seleciona el perfil/role del usuario.',
            'prodile.not_in' => 'Selecciona un perfil/role distinto a Elegir',
            'password.required' => 'Ingresa el password',
            'password.min' => 'El password debe tener al menos tres caracteres.',
        ];
        
        $this->validate($rules, $messages);


        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)

        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }

        $this->resetUI();
        $this->emit('user-added', 'Usuario registrado');
    }

    public function Update($param) {
        
            $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'name' => 'required|min:3',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'
        ];

        $messages = [
            'name.required' => 'Ingresa el nombre',
            'name.min' => 'El nombre del usuario debe tener al menos tres caracteres.',
            'email.required' => 'Ingresa el correo.',
            'email.email' => 'Ingresa un correo válido.',
            'email.unique' => 'El email ya existe en sistema.',
            'status.required' => 'Selecciona el estatus del usuario.',
            'status.not_in' => 'Selecciona el estatus.',
            'profile.required' => 'Seleciona el perfil/role del usuario.',
            'prodile.not_in' => 'Selecciona un perfil/role distinto a Elegir',
            'password.required' => 'Ingresa el password',
            'password.min' => 'El password debe tener al menos tres caracteres.',
        ];
        
        $this->validate($rules, $messages);

        $user = User::find($this->selected_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile' => $this->status,
            'password' => bcrypt($this->password)
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $imageTemp = $user->image;

            $user->image = $customFileName;
            $user->save();

            if ($imageTemp != null) {
                if (file_exists('storage/users/' . $imageTemp)) {
                    unlink('storage/users/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('user-updated', 'El usuario se ha actualizado');
    }

    public function destroy(User $user) {
        if ($user) {
            $sales = Sale::where('user_id', $user->id)->count();
            if ($sales > 0) {
                /** Quedaría inconsistente la información en la Base de Datos */
                $this->emit('user-withsales', 'No es posible eliminar el usuario debido a que tiene ventas registradas');
            } else {
                $user->delete();
                $this->resetUI();
                $this->emit('user-deleted', 'Usuario eliminado');
            }
        }
    }
}
