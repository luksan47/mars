<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-sm-12">
            <h2 class="mt-3 mb-3">Fájl feltöltése</h2>

            <div class="row">
                <div class="col-sm-10 offset-sm-1">
                    <div class="bd-callout bd-callout-information">
                        <p class="text-justify">
                            A feltölteni kívánt fájlokat, dokumentumokat PDF formátumban vagy képként (.png, .jpg, .jpeg, .gif, .svg) tudod feltölteni. A maximális méret: 2.0 MB.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('applicant.uploads.upload') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="form-group row">

                    <label for="upload_file_name" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                        Fájl megnevezése:
                    </label>
                    <input type="text" class="form-control col-sm-7" name="name" id="upload_file_name" value="" required>

                </div>

                <div class="form-group row">

                    <label for="upload_file_name" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                        Fájl:
                    </label>

                    <div class="btn-group col-sm-7 px-0">
                        <div class="btn btn-primary col-sm-3 p-0">
                            <label class="mb-0 d-box w-100 text-center" style="padding: 0.375rem 0.75rem; cursor: pointer;" for="upload_file_file">
                                Böngészés
                            </label>
                        </div>

                        <div class="btn btn-outline-primary col-sm-9 disabled p-0">
                            <label class="mb-0 d-flex" style="padding: 0.375rem 0.75rem; cursor: pointer;" id="upload_file_file_display" for="upload_file_file">
                                ~/.ssh/id_rsa
                            </label>
                        </div>
                    </div>

                </div>
                <input type="file" hidden accept="application/pdf, image/*" required  onchange="document.getElementById('upload_file_file_display').innerText = this.value.substr(this.value.lastIndexOf('\\')+1)"   id="upload_file_file" name="file_file" required>

                <div class="form-group row">
                    <input type="submit" class="btn btn-primary form-control col-sm-10 offset-sm-1" value="Feltöltés">
                </div>
            </form>

        </div>
    </div>
</div>
