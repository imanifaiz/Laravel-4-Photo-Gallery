<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Awesome Photo Gallery</title>
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">
	<style type="text/css">
        body { padding-top:60px; }
		form ul {list-style: none}
	</style>
</head>

<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Photo Gallery</a>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li>{{ link_to('/', 'Home') }}</li>
                    <li>{{ link_to('new/album', 'New album') }}</li>
                    <li>{{ link_to('new/photo', 'Add photo') }}</li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>

	<div class="container">
		@if (Session::has('message'))
        	<div class="flash alert">
        		<p>{{ Session::get('message') }}</p>
    		</div>
		@endif

		@yield('content')
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>

    <script>
        $(function() {

            $("#images").sortable({
                start : function(event, ui) {
                    ui.item.addClass('active');
                },
                stop : function(event, ui) {
                    ui.item.removeClass('active');

                    $.each($('#images .thumbnail'), function(index, event) {
                        $(this).find('.display-order').html(parseInt(index, 10)+1);
                    });
                }
            });
            $("#images").disableSelection();
            
        });
    </script>
</body>

</html>