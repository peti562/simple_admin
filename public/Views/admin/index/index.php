<!DOCTYPE html>
<html lang="en">
<script src='https://www.google.com/recaptcha/api.js' async defer></script>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=(isset($this->title)) ? $this->title : 'Title'; ?></title>

	<!-- Bootstrap Core CSS -->
	<link href="<?=$this->env->get('url')?>public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
  <link href="<?=$this->env->get('url')?>public/admin/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="<?=$this->env->get('url')?>public/admin/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=$this->env->get('url')?>public/admin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <script type="text/javascript">
            var onloadCallback = function() {
                grecaptcha.render('html_element', {
                    'sitekey' : '6Ldo6eYUAAAAAGOQR6ia-Sxup5MJhR_uwwguEUyx'
                });
            };
        </script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Hi</h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-signin" action="<?=$this->env->get('url')?>admin/index/run" method="post" role="form">
                            <fieldset>
                                <?if($this->incorrectDetails):?>
                                    <p class="bg-danger">
                                        A megadott bejelentkezesi adatok nem stimmelnek.
                                    </p>
                                <?endif;?>
                                <div class="form-group">
                                    <input id="username" name="username" placeholder="Username" type="text" class="form-control" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>

                                </div>
                                <?if($this->needCaptcha):?>
                                    <?if($this->failedCaptcha):?>
                                        <p class="bg-danger">
                                            A Captcha validalas nem volt sikeres.
                                        </p>
                                    <?endif;?>
                                    <div class="g-recaptcha" data-sitekey="<?=$this->env->get('google.site_key')?>"></div>
                                <?endif;?>
                                <button class="btn btn-lg btn-success btn-block" name="submit" type="submit">Sign in</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- jQuery -->
    <script src="<?=$this->env->get('url')?>public/admin/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$this->env->get('url')?>public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
    </script>

</body>

</html>
