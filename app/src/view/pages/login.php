<link href="<?=BRAND ?>css/signin.css" rel="stylesheet">  
<div class="container">

        <form class="form-signin" action="/login" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" id="email"  name="email" placeholder="Email address" autofocus>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
