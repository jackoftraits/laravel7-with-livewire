<div>
    <label>Name</label>
    <input wire:model="name" type="text" class="form-control" />
    @if ($errors->has('name'))
        <p style="color: red">{{$errors->first('name')}}</p>
    @endif

    <label>Email</label>
    <input wire:model="email" type="email" class="form-control" />
    @if ($errors->has('email'))
        <p style="color: red">{{$errors->first('email')}}</p>
    @endif

    @if ($email !== $prevEmail)
        <br/>
        <label>Current Password</label>
        <input wire:model="current_password_for_email" type="password" class="form-control" />
        @if ($errors->has('current_password_for_email'))
            <p style="color: red">{{$errors->first('current_password_for_email')}}</p>
        @endif
    @endif

    <label>Password</label>
    <input wire:model="password" type="password" class="form-control" />
    @if ($errors->has('password'))
        <p style="color: red">{{$errors->first('password')}}</p>
    @endif

    @if (!empty($password))
        <label>Password Confirmation</label>
        <input wire:model="password_confirmation" type="password" class="form-control" />
        @if ($errors->has('password_confirmation'))
            <p style="color: red">{{$errors->first('password_confirmation')}}</p>
        @endif
        <br/>
        <label>Current Password</label>
        <input wire:model="current_password_for_password" type="password" class="form-control" />
        @if ($errors->has('current_password_for_password'))
            <p style="color: red">{{$errors->first('current_password_for_password')}}</p>
        @endif        
    @endif

    <br/>
    <button wire:click="save" class="btn btn-primary">Save</button>
</div>
