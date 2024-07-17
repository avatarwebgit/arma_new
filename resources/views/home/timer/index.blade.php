<div class="clock" @if($timer_is_red==1)  style="color: #c20000 !important;" @endif>
    <div class="column">
        <div class="timer" style="width: 30px">{{ $hours }}</div>
        <div class="text hour">HR</div>
    </div>
    <div style="font-family:none !important" class="timer">:</div>
    <div class="column">
        <div class="timer" style="width: 30px">{{ $minutes }}</div>
        <div class="text">MIN</div>
    </div>
    <div style="font-family: normal !important" class="timer">:</div>
    <div class="column">
        <div class="timer" style="width: 30px">{{ $seconds }}</div>
        <div class="text">SEC</div>
    </div>
</div>
