<div class="clock">
    <div class="column">
        <div class="timer">{{ $hours }}</div>
        <div class="text hour">Hour</div>
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
