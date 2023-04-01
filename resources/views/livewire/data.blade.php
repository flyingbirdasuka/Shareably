<h2>practice favorited : {{ $practice_favorited }} <br></h2> 
<h2>practice most favorited : {{ $practice_most_favorited }} <br></h2> 
most viewed page :  {{ $most_viewed_page }} ({{ $most_viewd_page_count }} times)<br>
most used language : {{ $most_used_language }} ({{ $most_used_language_count }} times)<br>
most used user {{ $most_used_session_user}} ({{  $most_used_session_time  }} minutes)<br>
average session time : {{ $average_settion_time}} minutes<br>
average session time this week: {{ $average_settion_time_this_week }} minutes<br>
average session time this month: {{ $average_settion_time_this_month }} minutes<br>
most viewed page this week: {{ $most_viewed_page_this_week}} ({{ $most_viewed_page_this_week_count}} times)<br>
most viewed page this month: {{ $most_viewed_page_this_month}} ({{ $most_viewed_page_this_month_count}} times)<br>
most used language this week: {{ $most_used_language_this_week}} ({{ $most_used_language_this_week_count}} times)<br>
most used language this month: {{ $most_used_language_this_month}} ({{ $most_used_language_this_month_count}} times)<br>
most used user this week: {{ $most_used_session_user_this_week}} ({{ $most_used_session_time_this_week}} minutes)<br>
most used user this month: {{ $most_used_session_user_this_month}} ({{ $most_used_session_time_this_month}} minutes)<br>

range viewed: <p class="range_data"></p> : <p class="range_data"></p>  times <br>
range language: <p class="range_data"></p> : <p class="range_data"></p> times <br>
range session: <p class="range_data"></p>  : <p class="range_data"></p>  minutes <br>

average session time: <p class="range_data"></p>  minutes


<input type="text" name="daterange" value="01/01/2023 - 12/31/2023" />
<canvas id="userChart" height="40px"></canvas>
<canvas id="emailChart" height="40px"></canvas>
<canvas id="categoryChart" height="40px"></canvas>
<canvas id="practiceChart" height="40px"></canvas>
<!-- chart.js libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<!-- date range picker libraries -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">

  const all_element = ['user', 'email', 'category', 'practice'];
  const all_data = [ @js($user_data), @js($email_data), @js($category_data),@js($practice_data)];


  var dataSet = [];
  all_element.forEach((element, index) => {
    dataSet[index] = makeGraph(all_element[index], all_data[index]);
  });

  // create the graphs by using chart.js
  function makeGraph($element, $data){
    const ctx = document.getElementById(`${$element}Chart`);
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['all',
            'this week',
            'this month',],
        datasets: [{
          label: $element,
          backgroundColor: '#6366F1',
          data: $data,
          borderWidth: 1
        }]
      }
    });
    return chart;
  }


  // date range picker
  $(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) { // send the selected date range to livewire
      Livewire.emit('getDateRange', [start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD')]);
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
  });

  // adding and updating the chart after selecting on the date picker
  window.addEventListener('chart-update', event => {
    for (let i=0; i< dataSet.length; i++){ // when it is already range data, refresh
      if(dataSet[i].data['labels'].length > 3 ){
        dataSet[i].data['labels'].pop();
        dataSet[i].data['datasets'][0].data.pop();
      }
      dataSet[i].data['labels'].push(event.detail[0]);
      dataSet[i].data['datasets'][0].data.push(event.detail[`${i+1}`]);
      dataSet[i].update();
      }

  });
  // adding and updating the tiles after selecting on the date picker
  window.addEventListener('tiles-update', event => {
    document.querySelectorAll('p.range_data').forEach((element, index)=>{
      element.innerText = event.detail[index];
    })
  });

</script>