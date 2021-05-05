<div class="card">
  <div class="card-content">
    <span class="card-title">@lang('mr-and-miss.add-custom')</span>
      <div class="row">
        <div class="input-field col s3 switch">
          <label>
            @lang('mr-and-miss.private')
            <input name="is-public" type="checkbox">
            <span class="lever"></span>
            @lang('mr-and-miss.public')
          </label>
        </div>
        <div class="input-field col s1">
          <select name="mr-or-miss">
            <option value="Mr" selected>Mr</option>
            <option value="Miss">Miss</option>
          </select>
        </div>
        <x-input.text s=4 id="title" locale="mr-and-miss"/>
        <x-input.text s=4 id="votee" locale="mr-and-miss"/>
      </div>
      <blockquote>
        @lang('mr-and-miss.custom-category')
      </blockquote>
      <button class="btn waves-effect waves-light" type="submit" id="mr-submit" name="action">@lang('mr-and-miss.vote')
        <i class="material-icons right">send</i>
      </button>
  </div>
</div>

  @include('student-council.mr-and-miss.votefields', ['genderCheck' => "bazdmeg", 'custom' => true])

@push('scripts')
  <script>
    $(document).ready(function(){
      $('select').formSelect();
    });
  </script>
@endpush