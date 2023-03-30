<div>
    <h2>User information</h2> <br>
    user count: {{ $user_count }} <br>
    user signed up this week : {{ $user_signup_this_week }} <br>
    user signed up this month : {{ $user_signup_this_month }} <br>
    email subscription rate : {{ $email_subscription_rate }} % <br> 

    <hr>


    <h2>Usage information (Time)</h2> <br>
    <hr>


    <h2>Usage information (materials)</h2> <br>
    category count : {{ $category_count }} <br>
    practice count (all) : {{ $practice_count }} <br>
    practice added this week : {{ $practice_this_week }} <br>
    practice added this month : {{ $practice_this_month }} <br>
    practice favorited : {{ $practice_favorited }} <br>
    practice most favorited : {{ $practice_most_favorited->title }} <br>
    
    <hr>


    <h2>Usage information (pages)</h2> <br>

    visited pages per session
    @foreach($pages as $page)
        {{ $page }} <br>
    @endforeach

    <hr> <br>


    searches per session <br>
    @if($searches)
        @foreach($searches as $search)
            {{ $search }} <br>
        @endforeach
    @endif


    <hr> <br>


    locales per session <br>
    @foreach($locales as $locale)
        {{ $locale }} <br>
    @endforeach


</div>
