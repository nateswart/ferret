<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Ferret</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar-fixed-top.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Ferret</a>
        </div>
        <div class="navbar-collapse collapse">

          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://github.com/nateswart/ferret">Github repo</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <h1>Settings</h1>

<?php

define("GITHUB_API", "https://api.github.com/");
define("GITHUB_API_AUTH", GITHUB_API . "authorizations");
define("GITHUB_API_REPOS", GITHUB_API . "repos/");

$defaults = parse_ini_file("config.ini");

?>

      <form class="form-horizontal" role="form" method="post" action="#">
        <div class="form-group">
          <label for="username" class="col-sm-2 control-label">Username</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $defaults[username] ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="password" class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" value="<?php echo $defaults[password] ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="repo_owner" class="col-sm-2 control-label">Repo Owner</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="repo_owner" name="repo_owner" value="<?php echo $defaults[repo_owner] ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="repo" class="col-sm-2 control-label">Repo</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="repo" name="repo" value="<?php echo $defaults[repo] ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="make_filepath" class="col-sm-2 control-label">Make filepath</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="make_filepath" name="make_filepath" value="<?php echo $defaults[filepath] ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="branch" class="col-sm-2 control-label">Branch</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="branch" name="branch" value="<?php echo $defaults[branch] ?>">
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Generate</button>
          </div>
        </div>
      </form>

<?php

if($_POST['username']) {

echo "<h1>Github Private Repo</h1>";

$ch_auth = curl_init(GITHUB_API_AUTH);

curl_setopt($ch_auth, CURLOPT_HEADER, 0);

$data = '{"scopes":["repo"],"note":"Test"}';
curl_setopt($ch_auth, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch_auth, CURLOPT_USERPWD, $_POST['username'] . ":" . $_POST['password']);
curl_setopt($ch_auth, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch_auth);
$vars = json_decode($response);
curl_close($ch_auth);


$file_path = $_POST['repo_owner'] . "/" . $_POST['repo'] . "/contents/" . $_POST['make_filepath'];
$repo_url = GITHUB_API_REPOS . $file_path . "?access_token=" . $vars->token . "&ref=" . $_POST['branch'];

$ch_repo = curl_init($repo_url);

curl_setopt($ch_repo, CURLOPT_HEADER, 0);
curl_setopt($ch_repo, CURLOPT_RETURNTRANSFER, true);
$response2 = curl_exec($ch_repo);
$vars2 = json_decode($response2);

$url = $vars2->git_url . "?access_token=" . $vars->token;

echo "<a href='" . $url . "'>" . $url . "</a>";
curl_close($ch_repo);
}

?>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>

