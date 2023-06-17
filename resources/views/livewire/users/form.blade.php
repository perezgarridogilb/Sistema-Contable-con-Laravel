@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Gilberto P.">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
     </div>
     <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" wire:model.lazy="phone" class="form-control" placeholder="ej: 351 115 9551" maxlength="10">
            @error('phone') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
     </div>
     <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="example@email.com">
            @error('email') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
     </div>
     <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Contraeña</label>
            <input type="text" wire:model.lazy="password">
            @error('password') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
     </div>
     <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <select wire.model.lazy="status" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                <option value="Active" selected>Activo</option>
                <option value="Locked" selected>Bloqueado</option>
            </select>
            @error('status') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
     </div>
     <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Asignar Role</label>
            <select wire.model.lazy="role" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
     </div>

     <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Imagen de perfil</label>
        <input type="file" wire:model="image" id="" accept="image/x-png, image/jpeg, image/gif" class="form-control">
        @error('image') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
        </div>      
</div>

@include('common.modalFooter')
