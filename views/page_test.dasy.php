<!Doctype html>
<html>
<head>
	<meta charset="{{charset}}" />
	<title>{{page_title}}</title>
	<style>
		.menu_onglet {
			display: inline-block;
			margin-left: 20px;
		}
	</style>
</head>
<body>
<php>
	<nav>
		menu_onglets.each((titre, lien) => {
			print '<div class="menu_onglet"><a href="'.$lien.'"> '.$titre.' </a></div>'
		});
	</nav>
	<hr>
	<div>
		<table>
			let header = $tableau[0];
			<tr>
				header.each((key, value) => {
					print '<th>'.$key.'</th>'
				});
			</tr>

			tableau.each((objet) => {
				print '<tr><td>'.$objet->Nom.'</td><td>'.$objet->Prenom.'</td><td>'.$objet->Telephone.'</td></tr>'
			});
		</table>
	</div>
</php>²
</body>
</html>