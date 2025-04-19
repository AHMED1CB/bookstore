<header class="header mb-3">
	<div class="container">
			
		<nav class="nav-links">
				
			<a class="logo" href="/">BookHunter</a>


			<ul class="links" style="display: none;">
				<li class="link">
					<a class="link-content <?=str_ends_with($_SERVER['REQUEST_URI'], '/')? 'active' : ''?>" href="/">Books</a>
				</li>
				
				<li class="link">
					<a class="link-content 
							<?=str_starts_with($_SERVER['REQUEST_URI'], '/profile') 
								?'active' : ''?>" href="/profile">	
							Profile
					</a>
				</li>
			
					<li class="link">
						<a class="link-content <?=str_starts_with($_SERVER['REQUEST_URI'], '/book')
								 ? 'active' : ''?>" href="/book">
							Upload Book
						</a>
				</li>
			

				<li class="link">
					
						<a class="link-content bg-danger" href="/handle/logout.php">
							Logout
						</a>
				</li>

			</ul>

			<a class="toggler d-block d-md-none"><img src="../assets/images/menu.svg"></a>
		</nav>


	</div>
</header>
