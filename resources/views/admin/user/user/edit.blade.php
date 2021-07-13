<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-10 offset-sm-1">

            <h2 class="mt-3 ">Szerkesztés</h2>
            <form action="{{ route('admin.users.update',['id' => $user['id'] ]) }}" method="POST"  class="form-horizontal">
                @csrf

                <div class="form-group form-row">
                    <label for="user_edit_role" class="col-form-label col-sm-4 font-weight-bolder text-justify">
                        Role:
                    </label>
                    <select name="user_role" id="user_edit_role" class="form-control col-sm-8">
                        @foreach ( \App\User::ROLES as $role)
                            <option value="{{ $role }}"  @if($role == $user['role']) selected="selected" @endif>{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-row">
                    <input type="submit" class="form-control btn btn-outline-primary" value="Mentés">
                </div>
            </form>
        </div>
    </div>
</div>
