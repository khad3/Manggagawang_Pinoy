<!-- resources/views/ar-profile.blade.php -->
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://aframe.io/releases/1.5.0/aframe.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/AR-js-org/AR.js@3.4.4/aframe/build/aframe-ar.js"></script>
  <style>
    .ui {position:fixed; top:0; left:0; right:0; padding:10px; background:rgba(0,0,0,.55); color:#fff; z-index:10;}
    .thumb {width:60px; height:60px; object-fit:cover; border-radius:6px; margin-right:6px;}
    .btn {display:inline-block; padding:6px 10px; background:#fff; color:#111; border-radius:6px; text-decoration:none; margin-right:6px;}
  </style>
</head>
<body style="margin:0; overflow:hidden;">

<div class="ui">
  <div><strong>{{ $applicant->personal_info->first_name }}</strong> — {{ $applicant->work_background->job_title }}</div>

  
<img src="{{ route('applicant.callingcard.display', ['id' => $applicant->id]) }}" alt="QR Code">
  {{-- Work Images --}}
  @if($images->count())
    <div style="margin-top:6px;">
      @foreach($images as $p)
        <img class="thumb" src="{{ asset('storage/'.$p->sample_work_image) }}" alt="">
      @endforeach
    </div>
  @endif

  {{-- YouTube Links --}}
  @if($videos->count())
    <div style="margin-top:8px;">
      @foreach($videos as $link)
        <a class="btn" href="{{ $link->sample_work_url }}" target="_blank" rel="noopener">Watch</a>
      @endforeach
    </div>
  @endif
</div>

<a-scene embedded arjs="sourceType: webcam; debugUIEnabled: false;">
  <a-marker preset="hiro">
    <a-image src="{{ asset('storage/'.$applicant->work_background->profileimage_path) }}" width="1.2" height="0.9" position="0 0.45 0"></a-image>
    <a-text value="{{ $applicant->personal_info->first_name }}" position="-0.6 -0.25 0" width="2" color="#111"></a-text>

    {{-- Photos inside AR --}}
    @foreach($images as $i => $p)
      <a-image src="{{ asset('storage/'.$p->sample_work_image) }}"
               position="{{ ($i*0.8) - 0.8 }} -0.9 0"
               width="0.7" height="0.5"></a-image>
    @endforeach
  </a-marker>
  <a-entity camera></a-entity>
</a-scene>


</body>
</html>
