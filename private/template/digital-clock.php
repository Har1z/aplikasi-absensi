<style>
    #d-clock {
        margin: 20px auto;
        padding: 0;
        width: 100%;
        text-align: center;
        line-height: 40px;
        color: #fff;
        font-size: 34px;
        font-family: calibri;
    }
</style>

<script>
    function updateClock() {
    var currentTime = new Date();
    // Operating System Clock Hours for 24h clock
    var currentHours = currentTime.getHours();
    // Operating System Clock Minutes
    var currentMinutes = currentTime.getMinutes();
    // Operating System Clock Seconds
    var currentSeconds = currentTime.getSeconds();
    // Adding 0 if Minutes & Seconds is More or Less than 10
    currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
    currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
    // display first 24h clock and after line break 12h version
    var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;
    // print clock js in div #clock.
    $("#d-clock").html(currentTimeString);}
    $(document).ready(function () {
    setInterval(updateClock, 1000);
});
</script>