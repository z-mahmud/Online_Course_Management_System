<nav class="navbar navbar-default">
  <div class="container">
    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <?php if(isset($studentId)){ ?>
      <a href="homepage.php" class="navbar-left" style="margin-top: 0px">
		<img src="../images/lb.png" width="50px" height="50px">
	</a>
      <a class="navbar-brand" href="homepage.php"><span><img src="" alt="" ></span>&nbsp;&nbsp;LearnBoost</a>
      <?php }else{ ?>
      <a href="login.php" class="navbar-left" style="margin-top: 0px"><img src="images/lb.png" width="50px" height="50px"></a>
      <a class="navbar-brand" href="login.php">&nbsp;&nbsp;LearnBoost</a>
      <?php } ?>
    </div>

    <!-- Collect the nav links, forms, and other content -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <?php if(isset($studentId)){ ?>
          <?php if($type=='student'){ ?>
          <li><a href="courses.php">Courses</a></li>
          <?php }else if($type=='faculty'){ ?>
          <li><a href="classes.php">Classes</a></li>
          <?php } ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ucwords($name); ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="../signout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
            </ul>
          </li>
        <?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>