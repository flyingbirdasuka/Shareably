<h2>User information  practice most favorited : {{ $practice_most_favorited }} <br></h2> 
<input type="text" name="daterange" value="01/01/2023 - 12/31/2023" />
<canvas id="userChart" height="40px"></canvas>
<canvas id="emailChart" height="40px"></canvas>
<canvas id="categoryChart" height="40px"></canvas>
<canvas id="practiceChart" height="40px"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">

  const all_element = ['user', 'email', 'category', 'practice'];
  const all_data = [{
    "labels" :  @js($user_labels),
    "data" :  @js($user_data)
  },{
    "labels" :  @js($email_labels),
    "data" :  @js($email_data)
  },{
    "labels" :  @js($category_labels),
    "data" : @js($category_data)
  },{
    "labels" :  @js($practice_labels),
    "data" :  @js($practice_data)
  }];

  var dataSet = [];
  all_element.forEach((element, index) => {
    dataSet[index] = makeGraph(all_element[index], all_data[index].labels, all_data[index].data);
  });


  function makeGraph($element, $labels, $data){
    const ctx = document.getElementById(`${$element}Chart`);
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: $labels,
        datasets: [{
          label: $element,
          backgroundColor: '#6366F1',
          data: $data,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
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

  // adding and updating the table after selecting on the date picker
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

</script>