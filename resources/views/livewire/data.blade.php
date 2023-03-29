<h2>User information  practice most favorited : {{ $practice_most_favorited }} <br></h2> 
<input type="text" name="daterange" value="01/01/2023 - 12/31/2023" />
<canvas id="userChart" height="40px"></canvas>
<canvas id="emailChart" height="40px"></canvas>
<canvas id="categoryChart" height="40px"></canvas>
<canvas id="practiceChart" height="40px"></canvas>

    <!-- user count: {{ $user_count }} <br>
    user signed up this week : {{ $user_signup_this_week }} <br>
    user signed up this month : {{ $user_signup_this_month }} <br>
    email subscription rate : {{ $email_subscription_rate }} % <br>

    <hr>


    <h2>Usage information (Time)</h2>
    <hr>


    <h2>Usage information (materials)</h2> <br> -->
    <!-- category count : {{ $category_count }} <br>
    practice count (all) : {{ $practice_count }} <br>
    practice added this week : {{ $practice_this_week }} <br>
    practice added this month : {{ $practice_this_month }} <br>
    practice favorited : {{ $practice_favorited }} <br> -->
  


  
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">
      // user
      var user_labels =  @js($user_labels);
      var user_data =  @js($user_data);
      const user_data_set = {
        labels: user_labels,
        datasets: [{
          label: 'user dataset',
          backgroundColor: '#6366F1',
          borderColor: '#6366F1',
          data: user_data,
        }]
      };
      const user_config = {
        type: 'bar',
        data: user_data_set,
        options: {}
      };
      const userChart = new Chart(
        document.getElementById('userChart'),
        user_config
      );

      // email
      var email_labels =  @js($email_labels);
      var email_data =  @js($email_data);
      const email_data_set = {
        labels: email_labels,
        datasets: [{
          label: 'email dataset',
          backgroundColor: '#6366F1',
          borderColor: '#6366F1',
          data: email_data,
        }]
      };
      const email_config = {
        type: 'bar',
        data: email_data_set,
        options: {}
      };

      const emailChart = new Chart(
        document.getElementById('emailChart'),
        email_config
      );

      // category
      var category_labels =  @js($category_labels);
      var category_data =  @js($category_data);
      const category_data_set = {
        labels: category_labels,
        datasets: [{
          label: 'category dataset',
          backgroundColor: '#6366F1',
          borderColor: '#6366F1',
          data: category_data,
        }]
      };
      const category_config = {
        type: 'bar',
        data: category_data_set,
        options: {}
      };

      const categoryChart = new Chart(
        document.getElementById('categoryChart'),
        category_config
      );

      // practice
      var practice_labels =  @js($practice_labels);
      var practice_data =  @js($practice_data);
      const practice_data_set = {
        labels: practice_labels,
        datasets: [{
          label: 'practice dataset',
          backgroundColor: '#6366F1',
          borderColor: '#6366F1',
          data: practice_data,
        }]
      };
      const practice_config = {
        type: 'bar',
        data: practice_data_set,
        options: {}
      };

      const practiceChart = new Chart(
        document.getElementById('practiceChart'),
        practice_config
      );



      $(function() {
        $('input[name="daterange"]').daterangepicker({
          opens: 'left'
        }, function(start, end, label) { // send the selected date range to livewire
          Livewire.emit('getDateRange', [start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD')]);
          console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
      });

      window.addEventListener('chart-update', event => {
          if(userChart.data.labels.includes("selected date range")){
            userChart.data.labels.pop();
            userChart.data.datasets.forEach((dataset) => {
                dataset.data.pop();
            });
            // emailChart.data.labels.pop();
            // emailChart.data.datasets.forEach((dataset) => {
            //     dataset.data.pop();
            // });
            categoryChart.data.labels.pop();
            categoryChart.data.datasets.forEach((dataset) => {
                dataset.data.pop();
            });
            practiceChart.data.labels.pop();
            practiceChart.data.datasets.forEach((dataset) => {
                dataset.data.pop();
            });
          }
          userChart.data.labels.push(event.detail[0]);
          userChart.data.datasets.forEach((dataset) => {
                dataset.data.push(event.detail[1]);
          });
          userChart.update();

          // emailChart.data.labels.push(event.detail[0]);
          // emailChart.data.datasets.forEach((dataset) => {
          //       dataset.data.push(event.detail[2]);
          // });
          // emailChart.update();
          categoryChart.data.labels.push(event.detail[0]);
          categoryChart.data.datasets.forEach((dataset) => {
                dataset.data.push(event.detail[2]);
          });
          categoryChart.update();
          practiceChart.data.labels.push(event.detail[0]);
          practiceChart.data.datasets.forEach((dataset) => {
                dataset.data.push(event.detail[3]);
          });
          practiceChart.update();
      });

</script>