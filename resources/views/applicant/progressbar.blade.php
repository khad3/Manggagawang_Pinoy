@php
    $steps = [
        1 => 'Register',
        2 => 'Verification',
        3 => 'Account Info',
        4 => 'Personal Info',
        5 => 'Work Background',
        6 => 'Portfolio/Resume'
    ];
@endphp

<div class="progressbar">
    <ul class="steps">
        @foreach ($steps as $stepNumber => $stepName)
            <li class="{{ $currentStep == $stepNumber ? 'active' : ($currentStep > $stepNumber ? 'completed' : '') }}">
                <span>{{ $stepNumber }}</span> {{ $stepName }}
            </li>
        @endforeach
    </ul>
</div>

<style>
    .progressbar ul.steps {
        list-style-type: none;
        display: flex;
        justify-content: space-between;
        padding: 0;
    }
    .progressbar ul.steps li {
        flex-grow: 1;
        text-align: center;
        position: relative;
        color: #aaa;
    }
    .progressbar ul.steps li span {
        display: inline-block;
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-radius: 50%;
        background: #ddd;
        margin-bottom: 5px;
    }
    .progressbar ul.steps li.active span,
    .progressbar ul.steps li.completed span {
        background: #4CAF50;
        color: white;
    }
    .progressbar ul.steps li.completed {
        color: #4CAF50;
    }
    /* Add connecting lines */
    .progressbar ul.steps li:not(:last-child)::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        background: #ddd;
        top: 15px;
        left: 50%;
        z-index: -1;
    }
    .progressbar ul.steps li.completed:not(:last-child)::after {
        background: #4CAF50;
    }
</style>
