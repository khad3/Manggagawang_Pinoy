<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Business Card</title>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
    <style>
        body {
            margin: 0;
            overflow: hidden;
            font-family: Arial, sans-serif;
            background: #111;
            color: #fff;
            text-align: center;
        }

        h1 {
            margin: 10px;
            color: #FFD700;
        }
    </style>
</head>

<body>
    <h1>Point your camera at the marker!</h1>

    <a-scene embedded arjs="sourceType: webcam;" vr-mode-ui="enabled: false">
        <a-assets>
            <!-- Profile picture -->
            @if ($retrievedProfile && $retrievedProfile->work_background && $retrievedProfile->work_background->profileimage_path)
                <img id="profilePic" src="{{ asset('storage/' . $retrievedProfile->work_background->profileimage_path) }}"
                    crossorigin="anonymous">
            @endif

            <!-- Portfolio -->
            @foreach ($retrievedPortfolio as $key => $portfolio)
                <img id="portfolio{{ $key }}"
                    src="{{ asset('storage/' . ($portfolio->sample_work_image ?? '')) }}" crossorigin="anonymous">
            @endforeach

            <!-- YouTube thumbnails -->
            @foreach ($retrievedYoutube as $key => $yt)
                <img id="ytThumb{{ $key }}"
                    src="https://img.youtube.com/vi/{{ $yt->sample_work_url }}/hqdefault.jpg" crossorigin="anonymous">
            @endforeach

            <!-- Card background -->
            <img id="cardTexture"
                src="data:image/svg+xml;utf8,
        <svg xmlns='http://www.w3.org/2000/svg' width='900' height='520'>
          <rect rx='32' ry='32' width='100%' height='100%' fill='%23ffffff' stroke='%23cccccc' stroke-width='4'/>
        </svg>">
        </a-assets>

        <!-- Marker -->
        <a-marker preset="hiro">
            <!-- Card background -->
            <a-image src="#cardTexture" position="0 0 0" rotation="-90 0 0" width="4" height="2.6"></a-image>

            <!-- Profile picture (left side on card) -->
            @if ($retrievedProfile && $retrievedProfile->work_background && $retrievedProfile->work_background->profileimage_path)
                <a-circle src="#profilePic" position="-1.5 0.5 0.01" rotation="-90 0 0" radius="0.55"></a-circle>
            @endif

            <!-- Personal info (center on card) -->
            <a-entity rotation="-90 0 0" position="-0.4 0.9 0.01">
                <a-text
                    value="{{ $retrievedProfile->personal_info->first_name ?? '' }} {{ $retrievedProfile->personal_info->last_name ?? '' }}"
                    color="#071124" align="left" width="2" position="0 0.2 0"></a-text>

                <a-text value="{{ $retrievedProfile->work_background->position ?? '' }}" color="#334155" align="left"
                    width="2" position="0 -0.2 0"></a-text>

                <a-text
                    value="{{ $retrievedProfile->email ?? '' }}\n📱 {{ $retrievedProfile->personal_info->phone_number ?? '' }}"
                    color="#475569" align="left" width="2" position="0 -0.65 0"></a-text>
            </a-entity>

            <!-- ==== Portfolio (Right side, grid 2x2) ==== -->
            <a-entity id="portfolioContainer" rotation="-90 0 0" position="2.3 0.3 0.06">
                @foreach ($retrievedPortfolio as $key => $portfolio)
                    @php
                        $x = ($key % 2) * 1.6; // two columns
                        $y = -floor($key / 2) * 1.2; // rows
                    @endphp
                    <a-image src="#portfolio{{ $key }}" width="1.2" height="0.9"
                        position="{{ $x }} {{ $y }} 0" class="clickable">
                    </a-image>
                @endforeach
            </a-entity>

            <!-- ==== YouTube (Left side, grid 2x2) ==== -->
            <a-entity id="youtubeContainer" rotation="-90 0 0" position="-3 0.3 0.06">
                @foreach ($retrievedYoutube as $key => $yt)
                    @php
                        $x = ($key % 2) * 1.4; // two columns
                        $y = -floor($key / 2) * 1.0; // rows
                    @endphp
                    <a-image src="#ytThumb{{ $key }}" width="1.2" height="0.8"
                        position="{{ $x }} {{ $y }} 0" class="clickable"
                        link="href: https://www.youtube.com/watch?v={{ $yt->sample_work_url }}; target: _blank">
                    </a-image>
                @endforeach
            </a-entity>

        </a-marker>

        <!-- Camera -->
        <a-entity camera></a-entity>
    </a-scene>
</body>

</html>
