<div class="timer_index clock" @if($timer_is_red==1)  style="color: #c20000 !important;" @endif>
    <div class="column">
        <div class="timer">{{ $hours }}</div>
        <div class="text hour">HR</div>
    </div>
    <div style="font-family:none !important" class="timer">:</div>
    <div class="column">
        <div class="timer">{{ $minutes }}</div>
        <div class="text">MIN</div>
    </div>
    <div style="font-family: normal !important" class="timer">:</div>
    <div class="column">
        <div class="timer">{{ $seconds }}</div>
        <div class="text">SEC</div>
    </div>
</div>
