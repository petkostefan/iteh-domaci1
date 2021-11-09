<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO DO</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

</head>
<body>
	<div class="container">
		<h1 style="letter-spacing: .2em;" class="font-weight-bold text-light text-center mt-5 mb-n5">TO DO</h1>
		<div id="task-container">
			<div id="form-wrapper">
				<form id="form">
					<div class="flex-wrapper">
						<div style="flex: 10">
							<label for="prioritet">Naziv</label>
							<input id="title" class="form-control" type="text" name="title" placeholder="Naziv zadatka">
						</div>
						<div style="flex: 1;"></div>
						<div style="flex: 3">
							<label for="prioritet">Prioritet</label>
							<input id="prioritet" class="form-control" type="number" name="priority" placeholder="1-10">
						</div>
						<div class="break"></div>
						<div style="flex: 10">
							<label for="prioritet">Opis</label>
							<input id="description" class="form-control" type="text" name="title" placeholder="Opis zadatka">
						</div>
						<div class="break"></div>
						<div style="flex: 2">
							<input id="submit" class="btn" value="Dodaj zadatak" type="submit" >
						</div>
						<div style="flex: 2">
							<button id="sort" style="float: right;" class="btn btn-info">Sortiraj po prioritetu</button>
						</div>
					</div>
				</form>
			</div>

			<div id="list-wrapper">
				<div class="task-wrapper font-weight-bold flex-wrapper">
                    <div style="flex:5">
                        Naziv zadatka
                    </div>
					<div style="flex:1">
                        Prioritet
                    </div>
					<div style="flex:3">
                        Datum i vreme
                    </div>
                </div>
                <div id="data-row-${i}" class="task-wrapper flex-wrapper">
                    <div title="Uradi domaci da bi mogao sto pre da se odmaras" style="flex:7">
                        Uradi domaci
                    </div>
					<div style="flex:1">
                        1
                    </div>
					<div style="flex:2">
                        20.11. 14:87
                    </div>
                    <div style="flex:1">
                        <button class="btn btn-sm btn-outline-info edit">Uredi</button>
                    </div>
                    <div style="flex:1">
                        <button class="btn btn-sm btn-outline-danger delete">Obriši</button>
                    </div>
                </div>
			</div>	
		</div>

	</div>

	<script type="text/javascript">

		var activeItem = null
		var list_snapshot = []

		buildList()

		function buildList(){
			var wrapper = document.getElementById('list-wrapper')

			var url = 'http://127.0.0.1:8000/api/task-list/'

			fetch(url)
			.then((resp) => resp.json())
			.then(function(data){
				console.log('Data:', data)

				var list = data
				for (var i in list){
					try{
						document.getElementById(`data-row-${i}`).remove()
					}catch(err){

					}

					var title = `<span class="title">${list[i].title}</span>`
					if (list[i].completed == true){
						title = `<strike class="title">${list[i].title}</strike>`
					}

					var item = `
						<div id="data-row-${i}" class="task-wrapper flex-wrapper">
							<div style="flex:7">
								${title}
							</div>
							<div style="flex:1">
								<button class="btn btn-sm btn-outline-info edit">Edit </button>
							</div>
							<div style="flex:1">
								<button class="btn btn-sm btn-outline-dark delete">-</button>
							</div>
						</div>
					`
					wrapper.innerHTML += item
				}

				if (list_snapshot.length > list.length){
					for (var i = list.length; i < list_snapshot.length; i++){
						document.getElementById(`data-row-${i}`).remove()
					}
				}

				list_snapshot = list


				for (var i in list){
					var editBtn = document.getElementsByClassName('edit')[i]
					var deleteBtn = document.getElementsByClassName('delete')[i]
					var title = document.getElementsByClassName('title')[i]


					editBtn.addEventListener('click', (function(item){
						return function(){
							editItem(item)
						}
					})(list[i]))


					deleteBtn.addEventListener('click', (function(item){
						return function(){
							deleteItem(item)
						}
					})(list[i]))

					
					title.addEventListener('click', (function(item){
						return function(){
							strikeUnstrike(item)
						}
					})(list[i]))
				}
			})
		}


		var form = document.getElementById('form-wrapper')
		form.addEventListener('submit', function(e){
			e.preventDefault()
			console.log('Form submitted')
			var url = 'http://127.0.0.1:8000/api/task-create/'
			if (activeItem != null){
				var url = `http://127.0.0.1:8000/api/task-update/${activeItem.id}/`
				activeItem = null
			}

			var title = document.getElementById('title').value
			fetch(url, {
				method:'POST',
				headers:{
					'Content-type':'application/json',
				},
				body:JSON.stringify({'title':title})
			}
			).then(function(response){
				buildList()
				document.getElementById('form').reset()
			})
		})


		function editItem(item){
			console.log('Item clicked:', item)
			activeItem = item
			document.getElementById('title').value = activeItem.title
		}


		function deleteItem(item){
			console.log('Delete clicked')
			fetch(`http://127.0.0.1:8000/api/task-delete/${item.id}/`, {
				method:'DELETE', 
				headers:{
					'Content-type':'application/json',
				}
			}).then((response) => {
				buildList()
			})
		}

		function strikeUnstrike(item){
			console.log('Strike clicked')

			item.completed = !item.completed
			fetch(`http://127.0.0.1:8000/api/task-update/${item.id}/`, {
				method:'POST', 
				headers:{
					'Content-type':'application/json',
				},
				body:JSON.stringify({'title':item.title, 'completed':item.completed})
			}).then((response) => {
				buildList()
			})
		}


	</script>

</body>
</html>