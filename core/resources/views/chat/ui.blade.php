<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airshop - </title>
    <link rel="stylesheet" href="/assets/templates/basic/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/chat/chat.ui.css">
	<link rel="stylesheet" href="/assets/chat/material_icons/css/materialdesignicons.css">
</head>
<body>
<div id="app">

<main class="content" >
    <div style="height: 70px;" class="px-2 d-flex bg-primary align-items-center">
		<a href="/{{$user_type}}">
			<img src="/assets/images/logoIcon/logo.png" alt="" height="50px">
		</a>
	</div>
    <div class="container-fluid p-0 shadow mt-2">
		<div class="card chat-card">
			<div class="row g-0">
				
					<recent-chats :auth_user="{{$user->id}}" auth_type="{{$user_type}}" auth_email="{{$user->email}}" current="{{isset($current) ? $current->hash : ''}}"></recent-chats>
                    <!-- <a href="#" class="list-group-item list-group-item-action border-0">
						<div class="badge bg-primary text-white float-right">5</div>
						<div class="d-flex align-items-start">
							<img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
							<div class="flex-grow-1 ml-3">
								Vanessa Tucker
								<div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
							</div>
						</div>
					</a>
                    <a href="#" class="list-group-item list-group-item-action border-0">
						<div class="badge bg-primary text-white float-right">5</div>
						<div class="d-flex align-items-start">
							<img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
							<div class="flex-grow-1 ml-3">
								Vanessa Tucker
								<div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
							</div>
						</div>
					</a> -->
					<chat-with now="{{$now}}" :auth_user="{{$user->id}}" auth_type="{{$user_type}}" auth_email="{{$user->email}}" current="{{isset($current) ? $current->hash : ''}}"></chat-with>
			</div>
		</div>
	</div>
</main>
</div>

<script src="/core/public/js/app.js" defer></script>

</body>
</html>