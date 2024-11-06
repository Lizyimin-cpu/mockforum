<style>
  .logo {
    margin: auto;
    background: white;
    padding: 2px;
    width: 5rem;
    height: 2.5rem;
  }

  .avatar {
    border-radius: 100%;
    width: 30px;
    height: 30px;
    align-items: center;
    justify-content: center;
    border: 1px solid;
  }

  .avatar img {
    max-width: calc(100%);
    max-height: calc(100%);
    border-radius: 100%;
  }
</style>

<nav class="navbar navbar-light fixed-top" style="padding:0;min-height: 3.5rem;background-color:#3F51B5 !important;line-height: 2.5rem;">
  <div class="container-fluid mt-2 mb-2">
    <div class="col-lg-12">
      <div class="col-md-1 float-left" style="display: flex;">
        <img class="logo" src="<?php echo $_SESSION['system_img'] ?>">
      </div>
      <div class="col-md-4 float-left text-white">
        <large><b><?php echo $_SESSION['system_name'] ?></b></large>
      </div>
      <div class="col-md-4 float-left">
        <form id="manage-search">
          <input type="text" placeholder="搜索" id="find" class="form-control" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
        </form>
      </div>
      <div class="float-right">
        <div class=" dropdown mr-4">
          <img class="avatar" src=<?php echo $_SESSION['login_avatar'] ? '"' . $_SESSION['login_avatar'] . '"' : "./assets/img/user.png" ?>>
          <a href="#" class="text-white dropdown-toggle" id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login_name'] ?> </a>
          <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
            <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account"><i class="fa fa-cog"></i> 管理帐户</a>
            <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> 退出</a>
          </div>
        </div>
      </div>
    </div>

</nav>

<script>
  $('#manage_my_account').click(function() {
    uni_modal("管理帐户", "manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own")
  })
  $('#find').keypress(function(e) {
    if (e.which == 13) {
      $('#manage-search').submit()
    }
  })
  $('#manage-search').submit(function(e) {
    e.preventDefault()
    location.href = "index.php?page=search&keyword=" + $('#find').val()
  })
</script>