<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
function nextOccurance(day, hour, minute) {
  d = new Date();
  d.setDate(d.getUTCDate() + (7 + day - d.getUTCDay()) % 7)
  d.setUTCHours(hour, minute, 0, 0);
  return d;
};

setInterval(function(){
  var now = new Date();
  var start_service_times = [
  	nextOccurance(7, 14, 0) - now,
  	nextOccurance(7, 16, 0) - now
  ];
  var end_service_times = [
  	nextOccurance(7, 15, 30) - now,
  	nextOccurance(7, 17, 30) - now
  ];
  var next_start = Math.min.apply(Math, start_service_times);
  var next_end = Math.min.apply(Math, end_service_times);
  document.getElementById("days").innerText = parseInt(next_start / (1000*60*60*24));
  document.getElementById("hours").innerText = parseInt(next_start / (1000*60*60)) % 24;
  document.getElementById("minutes").innerText = parseInt(next_start / (1000*60)) % 60;
  document.getElementById("seconds").innerText = parseInt(next_start / (1000)) % 60;
}, 1000);</script>
<!-- end Simple Custom CSS and JS -->
