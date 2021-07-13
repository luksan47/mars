<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-sm-12">
            <h2 class="mt-3 mb-3">Profilkép <small style="font-size:0.5em"><em>(szükséges)</em></small></h2>

            <div class="row">
                <div class="d-block col-md-4 offset-sm-1 mb-4">
                    <img src="{{ $profile_picture_path ?? 'images/default-avatar.jpg' }}" class="img-fluid border">
                </div>

                <div class="col">
                    <form action="{{ route('applicant.uploads.profile_picture.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="form-group row">
                            <label for="" class="offset-sm-1 font-weight-bolder text-justify mb-n2">Profilkép kiválasztása</label>
                        </div>
                        <div class="form-group row">
                            <div class="btn-group col-sm-10 offset-sm-1 px-0">
                                <div class="btn btn-primary col-sm-4 p-0">
                                    <label class="mb-0 d-box w-100 text-center" style="padding: 0.375rem 0.75rem; cursor: pointer; " for="profile_picture_file_file">
                                        Böngészés
                                    </label>
                                </div>

                                <div class="btn btn-outline-primary col-sm-8 disabled p-0">
                                    <label class="mb-0 d-flex" style="padding: 0.375rem 0.75rem; cursor: pointer;" id="profile_picture_file_display" for="profile_picture_file_file">
                                        /etc/shadow
                                    </label>
                                </div>
                            </div>
                        </div>
                        <input type="file" hidden accept="image/*" required  onchange="document.getElementById('profile_picture_file_display').innerText = this.value.substr(this.value.lastIndexOf('\\')+1)" id="profile_picture_file_file" name="profile_picture_file" required>
                        <div class="form-group row">
                            <input type="submit" class="col-sm-10 offset-sm-1 btn btn-primary form-control mt-n2" value="Feltöltés">
                        </div>
                    </form>

                    <div class="bd-callout bd-callout-information col-sm-10 offset-sm-1">
                        <p class="text-justify">
                            Érdemes egy legalább 350px szélességű képet választani.<br>
                            Maximális méret: 2.0 MB  Fájl formátumok: .png, .jpg, .jpeg, .gif, .svg
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
