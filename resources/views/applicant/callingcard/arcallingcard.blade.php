<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Business Card</title>

    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>

    <script>
        AFRAME.registerComponent('open-link', {
            schema: {
                url: {
                    type: 'string'
                }
            },
            init: function() {
                this.el.addEventListener('click', () => {
                    window.open(this.data.url, '_blank');
                });
            }
        });
    </script>
    <style>
        body {
            margin: 0;
            overflow: hidden;
            background: #0B1A39;
            /* Dark blue */
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        h1 {
            color: #ffffff;
            margin-top: 15px;
            font-size: 22px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Point your camera at the marker!</h1>

    <a-scene embedded arjs="sourceType: webcam;" vr-mode-ui="enabled: false">
        <a-assets>
            @php
                $profileImage = $retrievedProfile?->work_background?->profileimage_path ?? null;
            @endphp

            @if ($profileImage && Storage::exists('public/' . $profileImage))
                <img id="profilePic" src="{{ asset('storage/' . $profileImage) }}" crossorigin="anonymous">
            @else
                <img id="profilePic" src="{{ asset('img/workerdefault.png') }}" crossorigin="anonymous">
            @endif


            <!-- Portfolio -->
            @foreach ($retrievedPortfolio as $key => $portfolio)
                <img id="portfolio{{ $key }}"
                    src="{{ asset('storage/' . ($portfolio->sample_work_image ?? '')) }}" crossorigin="anonymous">
            @endforeach

            <!-- YouTube Thumbnails -->
            @foreach ($retrievedYoutube as $key => $yt)
                <img id="ytThumb{{ $key }}"
                    src="https://img.youtube.com/vi/{{ $yt->sample_work_url }}/hqdefault.jpg" crossorigin="anonymous">
            @endforeach

            <!-- SVG Business Card Background -->
            <img id="cardTexture"
                src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='1000' height='600' viewBox='0 0 1000 600'>
       <rect x='0' y='0' width='500' height='600' fill='%23000082'/>
       <rect x='500' y='0' width='500' height='600' fill='%23ffffff'/>
     </svg>">

            <img id="workerLogo" src="{{ asset('img/logo.png') }}" crossorigin="anonymous">

        </a-assets>





        <a-marker preset="hiro">




            <!-- Pangpindot-->
            <a-entity camera look-controls>
                <a-entity cursor="rayOrigin: mouse"></a-entity>
            </a-entity>
            <!-- Background Card -->
            <a-image src="#cardTexture" width="5" height="3" rotation="-90 0 0"></a-image>

            <!-- RIGHT SIDE: Logo + Profile Picture -->
            <a-entity rotation="-90 0 0" position="1.5 0.5 -0.3">
                <!-- Background circle with logo -->
                <a-circle src="#workerLogo" radius="1.2" position="-0.25 -0.3 -0.40" scale="1.02 1.05 1.6"></a-circle>

                <!-- Foreground profile picture -->
                <a-circle src="#profilePic" radius="0.8" position="-0.25 -0.25 -0.35"></a-circle>
            </a-entity>

            <!-- LEFT STACK: Name, Work, Portfolio, Email -->
            <a-entity rotation="-90 0 0" position="-2.4 0.8 -1.0">

                <!-- Name -->
                <a-text
                    value="{{ strtoupper($retrievedProfile->personal_info->first_name . ' ' . $retrievedProfile->personal_info->last_name) }}"
                    width="3.5" color="#ffffff" align="left" position="0 0 -0.5" wrap-count="25" font="mozillavr">
                </a-text>

                <!-- Work -->
                <a-text value="{{ strtoupper($retrievedProfile->work_background->position) }}" width="2.8"
                    color="#ffffff" align="left" position="0 -0.5 -0.5"font="mozillavr"></a-text>

                <!--- tesda certification -->
                <a-text value="{{ strtoupper($retrievedcertification->certifications->certification_program) }}"
                    width="2.8" color="#ffffff" align="left" position="0 -0.5 -0.5"font="mozillavr"></a-text>

                <!-- Portfolio -->
                <a-entity position="0.7 -1.1 -0.55">
                    @foreach ($retrievedPortfolio as $key => $portfolio)
                        @php
                            $x = ($key % 2) * 1.2;
                            $y = -floor($key / 2) * 1.0;
                            $imageUrl = asset('storage/' . ($portfolio->sample_work_image ?? ''));
                        @endphp
                        <a-image src="#portfolio{{ $key }}" width="1.0" height="0.75"
                            position="{{ $x }} {{ $y }} 0"
                            open-link="url: {{ $imageUrl }}">
                        </a-image>
                    @endforeach
                </a-entity>


                <!-- Email -->

                <a-text value=" {{ strtoupper($retrievedProfile->email) }}" width="2.5" color="#ffffff"
                    align="left" position="0.2 -1.98 -0.5" font="mozillavr"></a-text>

                <a-text
                    value=" {{ strtoupper(
                        $retrievedProfile->personal_info->house_street .
                            ', ' .
                            $retrievedProfile->personal_info->barangay .
                            ', ' .
                            $retrievedProfile->personal_info->city .
                            ', ' .
                            $retrievedProfile->personal_info->province,
                    ) }}"
                    width="2.3" color="#ffffff" align="left" position="0.2 -2.2 -0.5"font="mozillavr"></a-text>

                <a-text
                    value=" {{ strtoupper(optional($retrievedProfile->appliedJobs->first())->cellphone_number ?? 'NOT AVAILABLE') }}"
                    width="2.5" color="#ffffff" align="left" position="0.2 -1.8 -0.5"font="mozillavr"></a-text>

            </a-entity>



            <!-- YouTube Section -->
            <a-entity rotation="-90 0 0" position="-0.6 0.3 0.1">
                @foreach ($retrievedYoutube as $key => $yt)
                    @php
                        $videoId = $yt->sample_work_url;

                        // Handle full YouTube URL
                        if (str_contains($videoId, 'youtube.com')) {
                            parse_str(parse_url($videoId, PHP_URL_QUERY), $ytQuery);
                            $videoId = $ytQuery['v'] ?? null;
                        }

                        // Handle short youtu.be links
                        if (str_contains($videoId, 'youtu.be')) {
                            $videoId = basename(parse_url($videoId, PHP_URL_PATH));
                        }
                    @endphp

                    @if ($videoId)
                        <a-image src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg" width="1.0"
                            height="0.75" position="{{ $key * 1.25 }} 0 0"
                            open-link="url: https://www.youtube.com/watch?v={{ $videoId }}">
                        </a-image>
                    @endif
                @endforeach
            </a-entity>
        </a-marker>

        <a-entity camera></a-entity>
    </a-scene>

</body>

</html>
