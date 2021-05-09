@foreach ($categories as $category)
  @if (($custom == true && $category->custom == true) ||
      ($custom == false && $category->mr == $genderCheck && $category->custom == false))
    @if ($category->public || $category->created_by == Auth::user()->id)
      <div class="row scale-transition" style="margin:0">
        <div class="col s5" style="padding: 0.8rem;">
            {{ $category->title }}
        </div>
        @php
          $voteInfo = Auth::user()->votedFor($category);
        @endphp
        <div class="col s6">
            <div
              id="select-ui-{{ $category->id }}"
              @if ($voteInfo['voted'] && $voteInfo['vote']->votee_id === null)
                hidden
              @endif
            >
              <x-input.select only-input :id="'select-' . $category->id" :elements="$users" without-placeholder allow-empty without-label once
                  :default="($voteInfo['voted'] && $voteInfo['vote']->votee_id !== null ? $voteInfo['vote']->votee_id : null)"
                />
            </div>
            <textarea id="raw-{{ $category->id }}" name="raw-{{ $category->id }}" class="materialize-textarea mr-textarea"
              @if (!($voteInfo['voted'] && $voteInfo['vote']->votee_name !== null))
                hidden
              @endif
              >@if ($voteInfo['voted'] && $voteInfo['vote']->votee_name !== null){{ $voteInfo['vote']->votee_name }}@endif</textarea>
        </div>
        <div class="col s1">
            <button class="btn-floating waves-effect waves-light right input-changer" id="button-{{ $category->id }}">
                <i class="material-icons" data-number="{{ $category->id }}">border_color</i>
            </button>
        </div>
      </div>
    @endif
  @endif
@endforeach

<button class="btn waves-effect waves-light" type="submit" id="mr-submit" name="action">@lang('mr-and-miss.vote')
  <i class="material-icons right">send</i>
</button>
