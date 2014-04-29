<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>bhapp</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
  </head>
  <body>
  
    <!-- navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top mainNav" role="navigation">
      <div class="container">
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">matches</a></li>
            <li><a href="#">livescore</a></li>
            <li><a href="#">streaks</a></li>
            <li><a href="#">statistics</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
            <li><a href="#">money</a></li>
            <li class="active"><a href="#">money</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <!-- breadcrumbs -->
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Germany</a></li>
        <li><a href="#">3.Liga</a></li>
        <li class="active">Fixtures</li>
      </ol>
      <div class="pull-right">
        <span>fefence | <a href="#">settings</a> | <a href="#">log out</a></span>
      </div>
    </div>

    <div class="container">

      <div class="row">
        <div class="col-xs-9 noMarginPadding">
          <!-- main content -->
          <div class="page-header">
            <h3 class="noMarginPadding">Today's matches <small>28-Apr-14 (Mon)</small></h3>
          </div>
        </div>
        <div class="col-xs-3 noMarginPadding">
          <!-- calendar -->
          <div class="form-group pull-right" id="datepickid">
            <div class="input-group date">
              <input type="text" class="form-control input-sm"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            </div>
          </div>
        </div>
      </div>
      
      <hr/>
      
      <div class="row">
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
        <div class="col-xs-12" style="padding: 0px; margin: 0px;">
          <div class="col-xs-1" style="background-color: #ddd;">1</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">2</div>
          <div class="col-xs-1" style="background-color: #ddd;">3</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">4</div>
          <div class="col-xs-1" style="background-color: #ddd;">5</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">6</div>
          <div class="col-xs-1" style="background-color: #ddd;">7</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">8</div>
          <div class="col-xs-1" style="background-color: #ddd;">9</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">10</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">11</div>
          <div class="col-xs-1" style="background-color: #c0c0c0;">12</div>
        </div>
      </div>

      <h3>What changes</h3>
      <p class="lead">Disable the responsiveness of Bootstrap by fixing the width of the container and using the first grid system tier.</p>
      <p>Note the lack of the <code>&lt;meta name="viewport" content="width=device-width, initial-scale=1"&gt;</code>, which disables the zooming aspect of sites in mobile devices. In addition, we reset our container's width and are basically good to go.</p>

      <h3>Regarding navbars</h3>
      <p>As a heads up, the navbar component is rather tricky here in that the styles for displaying it are rather specific and detailed. Overrides to ensure desktop styles display are not as performant or sleek as one would like. Just be aware there may be potential gotchas as you build on top of this example when using the navbar.</p>

      <h3>Browsers, scrolling, and fixed elements</h3>
      <p>Non-responsive layouts highlight a key drawback to fixed elements. <strong class="text-danger">Any fixed component, such as a fixed navbar, will not be scrollable when the viewport becomes narrower than the page content.</strong> In other words, given the non-responsive container width of 970px and a viewport of 800px, you'll potentially hide 170px of content.</p>
      <p>There is no way around this as it's default browser behavior. The only solution is a responsive layout or using a non-fixed element.</p>

    </div> <!-- /container -->
    <div id="footer">
      <div class="container">
        <p class="text-muted"> today's matches: <strong><a href="#">43</a></strong><strong> | </strong>BSF for today's matches: <strong>2213€</strong><strong> | </strong>Total BSF: <strong>5346€</strong></p>
      </div>
    </div>
    <script type="text/javascript">
      
      $('#datepickid div').datepicker({
        format: "dd-M-yy (D)",
        weekStart: 1,
        orientation: "top auto",
        // autoclose: false,
        todayHighlight: true,
        multidate: true,
        beforeShowDay: function (date) {
          if (date.getMonth() == (new Date()).getMonth())
            switch (date.getDate()){
              case 4:
                return {
                  tooltip: 'Example tooltip',
                  classes: 'text-danger'
                };
              case 8:
                return false;
              case 12:
                return "green";
            }
        }
        }).on('changeDate', function(e){
          $('#dt_due').val(e.format('dd/mm/yyyy'))
        });
    </script>
  </body>
</html>