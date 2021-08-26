<div>
    @foreach($menus as $menu)
        <div class="form-group col-md-6">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="menu[]" value="{{ $menu->id }}" @if($role_menus->contains($menu->id)) checked @endif>
                    <span>{{ $menu->title }}</span>
                </label>
            </div>
        </div>
    @endforeach

    <input type="hidden" name="role_id" value="{{ $role_id }}">
    @csrf
</div>
