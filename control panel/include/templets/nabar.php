<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashpoard.php"><?php echo lang('home admin') ?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li ><a href="categories.php"><?php echo lang('Categories') ?></a></li>
        <li ><a href="item.php"><?php echo lang('ITEMS') ?></a></li>
        <li ><a href="member.php"><?php echo lang('MEMBERS') ?></a></li>
        <li ><a href="comment.php"><?php echo lang('COMMENTS') ?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('name page') ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php"> Vist Shop </a></li>
            <li><a href="member.php?do=edit&userid=<?php echo $_SESSION['ID']?>"><?php echo lang('edit profile') ?></a></li>
            <li><a href="#"><?php echo lang('setting') ?></a></li>
            <li><a href="logout.php"><?php echo lang('out') ?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>