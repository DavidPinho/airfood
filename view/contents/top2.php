<?php 

require_once '../model/User.class.php';
require_once '../model/UserDB.class.php';
?>


<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse"
				data-target=".nav-collapse"> <span class="icon-bar"></span> <span
				class="icon-bar"></span> <span class="icon-bar"></span>
			</a>
			<div class="nav-collapse collapse">
				<?php 
				if(isset($_SESSION['user'])){
					?>
				<p class="navbar-text pull-right" style="color: #ffffff">
					<?php 
					$user = User::createFromJson($_SESSION['user']);

					echo $user->getUserName().' - '?>
					<a href="../control/logout.php">Logout</a>
				</p>
				<?php }?>
				<ul class="nav">
					<li class="active"><a href="dashboard.php"><?php echo $lang->navbar_home?>
					</a></li>
					<li class="dropdown"><a href="#about" class="dropdown-toggle"
						data-toggle="dropdown"><?php echo $lang->navbar_manager?> </a>
						<ul class="dropdown-menu">
							<?php if($user->getAdmin()==1){?>
							<li><a href="users.php"><?php echo $lang->navbar_user?></a></li>
							<?php }?>
							<li><a href="itens.php"><?php echo $lang->navbar_item?></a></li>
							<li><a href="tokens.php"><?php echo $lang->navbar_token?></a></li>
							<li><a href="categories.php"><?php echo $lang->navbar_categories?></a></li>
							<li><a href="configurations.php">Configura&ccedil;&otilde;es</a></li>
						</ul>
					</li>
					<li><a href="contact.php"><?php echo $lang->navbar_contact?></a></li>
					 <ul class="nav nav-pills">
						<li class="active" style="color: #009ACD"><h4>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<?php if(isset($_GET['table'])){
														echo "Mesa: ", $_GET['table'];
													 }?></h4>
					</li>
					</ul>
					

				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>

