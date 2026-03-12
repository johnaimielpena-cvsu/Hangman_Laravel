<html>

<head>
	<title>Clinic Appointment</title>
	<link rel="stylesheet" href="style.css">
	<style>
		body>nav {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 20px;
			background-color: #333;
			color: #fff;
		}

		body>nav a {
			color: #fff;
			text-decoration: none;
			margin-left: 15px;
		}

		.hero-section img {
			width: 500px;
			height: auto;
			border-radius: 10px;
			margin-top: 20px;
		}

		.hero-section .clinic-images {
			display: flex;
			justify-content: center;
			gap: 20px;
		}

		.upButton {
			font-size: 20px;
			float: right;
			margin-top: -50px;
			margin-right: 20px;
			background-color: #333;
			color: #fff;
			padding: 10 15px;
			border-radius: 5px;
			text-decoration: none;
			width: auto;
			align-content: center;
		}

		.upButton a {
			color: #fff;
			text-decoration: none;
		}

		.timeNow {
			font-size: 16px;
			margin-top: -50px;
			margin-left: 20px;
			background-color: #333;
			color: #fff;
			padding: 10 15px;
			border-radius: 5px;
			width: auto;
			position: fixed;
			bottom: 20px;
			right: 20px;
		}

		/* Show when clinic is closed */
		#closedOverlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.95);
			color: white;
			display: none;
			/* Hidden by default */
			justify-content: center;
			align-items: center;
			flex-direction: column;
			z-index: 9999;
			font-size: 24px;
		}



		/* Modal Styling */

		/* Modal Background */
		.modal {
			display: none;
			position: fixed;
			z-index: 10000;

			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.7);
			justify-content: center;
			align-items: center;
		}

		/* Modal Box */
		.modal-content {
			background-color: white;
			padding: 20px;
			height: 42vh;
			width: auto;
			border-radius: 10px;
			display: flex;
			flex-direction: column;
			gap: 10px;
		}

		.modal-content .form-group{
			padding: 20px;
			background-color: white;
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 1rem;
			grid-template-areas: 
				"fullname fullname"
				"email email"
				"contact contact"
				"date time"
				"submit submit";
			width: auto;
		}
		.field.full { grid-area: fullname; }
		.field.email { grid-area: email; }
		.field.contact { grid-area: contact; }
		.field.date { grid-area: date; }
		.field.time { grid-area: time; }
		.field.submit { grid-area: submit; }
		

		.field.submit {
			display: flex;
			justify-content: center;
		}


		.modal-content label{
			margin-bottom: 0.25rem;
			font-weight:600;
		}
		.modal-content input{
			padding: 0.5rem;
			border: 1px solid #ccc;
			border-radius: 6px;
		}
		.modal-content input[type="text"],
		.modal-content input[type="email"],
		.modal-content input[type="number"]{
			width: 100%;
		}
		.modal-content input[type="submit"]{
			padding: 0.75rem 1.5rem;
			width: 150px;
			border: none;
			border-radius: 6px;
			background-color: blue;
			color: white;
			font-size: 1rem;
			cursor: pointer;
		}
		.modal-content input {
			padding: 8px;
		}

		.close {
			font-size: 22px;
			cursor: pointer;
			align-self: flex-end;
		}
	</style>
</head>

<body>
	<nav>
		<a href="index.html">Kurazoo</a>
		<a href="#">Login</a>
	</nav>
	<main class="hero-section" id="top">
		<h1>Kurazoo Clinic</h1>
		<p>Your Health, Our Priority</p>
		<div class="clinic-images">
			<img src="clinic.jpg" alt="Clinic Image">
			<img src="clinic.jpg" alt="Clinic Image">
			<img src="clinic.jpg" alt="Clinic Image">
		</div>
		<nav>
			<a href="#schedule" id="openModal">Schedule Appointment</a>
			<a href="appointments.html">View Appointments</a>
			<a href="#contact">Contact</a>
		</nav>
	</main>

	<!-- FORM SECTION FOR SHCEDULING APPPOINTMENT -->
	<section class="formSection" id="schedule">
		<h1>Schedule Appointment Here</h1>
		<form method="POST">
			<div class="form-group">
				<div class="field full">
					<label for="fullname">Full name:</label>
					<input type="text" id="fullname" name="fullname" required>
				</div>
				<div class="field email">
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" required>
				</div>
				<div class="field contact">
					<label for="contactNum">Contact Number:</label>
					<input type="number" id="contactNum" name="contactNum">
				</div>
				<div class="field date">
					<label for="appointmentDate">Appointment Date:</label>
					<input type="date" id="appointmentDate" name="appointmentDate">
				</div>
				<div class="field time">
					<label for="appointmentTime">Appointment Time:</label>
					<input type="time" id="appointmentTime" name="appointmentTime">
				</div>
				<div class="field submit">
					<input type="submit" name="submit" value="Submit" id="submit">
				</div>
			</div>
		</form>
	</section>


	<!-- FORM SECTION FOR SCHEDULING APPOINTMENT USING POP UP MODAL -->

	<!-- Modal Background -->
	<!-- <div id="appointmentModal" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<h2>Schedule Appointment</h2>

			<form id="appointmentForm">
				<div class="form-group">
					<div class="field full">
						<label>Full Name:</label>
						<input type="text" id="fullname" name="fullname" required>
					</div>
					<div class="field email">
						<label>Email:</label>
						<input type="email" id="email" name="email" required>
					</div>
					<div class="field contact">
						<label>Contact Number:</label>
						<input type="number" id="contactNum" name="contactNum">
					</div>
					<div class="field date">
						<label>Appointment Date:</label>
						<input type="date" id="appointmentDate" name="appointmentDate">
					</div>
					<div class="field time">
						<label>Appointment Time:</label>
						<input type="time" id="appointmentTime" name="appointmentTime">
					</div>
					<div class="field submit">
						<input type="submit" value="Submit">
					</div>
				</div>

			</form>
		</div>
	</div> -->

	<section class="tableSection" id="view">
		<h1>View Schedules Here!</h1>
		<table border="1" cellspacing="0">
			<thead>
				<th>Name</th>
				<th>Appointment Type</th>
				<th>Appointment Date</th>
				<th>Appointment Time</th>
			</thead>
			<tbody id="appointmentTable">

			</tbody>
		</table>
	</section>

	<!-- <div class="upButton">
		<a href="#top"> ^ </a>
	</div> -->
	<div class="timeNow">
		<p id="currentTime"></p>
		<script>
			function updateTime() {
				const now = new Date();
				const hours = now.getHours();
				// const minutes = String(now.getMinutes()).padStart(2, '0');
				const minutes = now.getMinutes();
				// const seconds = String(now.getSeconds()).padStart(2, '0');
				const seconds = now.getSeconds();

				const totalMinutes = hours * 60 + minutes;  // what is the hour now? 11 * total minutes (60) + what is the minutes of the current time(57) = 717
				const openTime = 8 * 60; // 8:00 AM in minutes total is 480
				const closeTime = 17 * 60; // 5:00 PM in minutes total is 1020 
				console.log(totalMinutes)


				// const isOpen = (hours >= 8 && hours < 17) || (hours === 17 && minutes === '00' && seconds === '00');  
				// check if total minutes is greater than = open time and if total minutes is less than the close time
				const isOpen = totalMinutes >= openTime && totalMinutes < closeTime;

				const status = isOpen ? 'Open' : 'Closed';

				const overlay = document.getElementById('closedOverlay');

				if (isOpen) {
					overlay.style.display = 'none';
				} else {
					overlay.style.display = 'flex';
				}

				document.querySelector('.timeNow').style.backgroundColor = isOpen ? 'green' : 'red';

				document.getElementById('currentTime').textContent = `Current Time: ${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')} - ${status}`;
				// document.getElementById('currentTime').textContent = `Current Time : ${hours}:${minutes}:${seconds} - ${status}`;

			}
			setInterval(updateTime, 1000);
			updateTime(); // Initial call to display time immediately
		</script>
	</div>
	<div id="closedOverlay">
		<h1>Clinic is Currently Closed</h1>
		<p>Operating Hours: 8:00 AM - 5:00 PM</p>
	</div>

	<footer>
		<div class="contactUs" id="contact">
			<div class="contactRight">
				<h2>Contact Us</h2>
				<p>Email: <a href="mailto:contact@kurazooclinic.com">contact@kurazooclinic.com</a> </p>
				<p>Phone: <a href="tel:+1234567890">+1 (234) 567-890</a></p>
				<p>Address: 123 Main Street, City, Country</p>
			</div>
			<div class="contactLeft">
				<h2>Social Medias</h2>
				<p>Facebook: <a href="https://www.facebook.com/kurazooclinic">Kurazoo Clinic</a> </p>
				<p>Instagram: <a href="https://www.instagram.com/kurazooclinic">Kurazoo Clinic</a></p>
				<p>TikTok: <a href="https://www.tiktok.com/kurazooclinic">Kurazoo Clinic</a></p>
			</div>
		</div>
		<center>
			<p>Copyright 2026 Kurazoo Clinic</p>
		</center>
	</footer>

	<!-- <script src="scheduleLocalSotrage.js"></script> -->
	<!-- <script src="popUp.js"></script>

	<script>
		let user = {
			name: "John Doe",
			email:"john.doe@example.com"
		}

		let userAccounts = JSON.parse(localStorage.getItem("userAccounts")) || [];
		userAccounts.push(user);

		userAccounts.forEach(function(userAcc){
			console.log(userAcc.name)
			console.log(userAcc.email)
		})

		localStorage.setItem("userAccounts", JSON.stringify(userAccounts));

	</script> -->
	<script>

		document.getElementById('submit').addEventListener('click', function (event){
			event.preventDefault(); // Prevent form submission

			let appointment = {
				fullname: document.getElementById('fullname').value,
				email: document.getElementById('email').value,
				contactNum: document.getElementById('contactNum').value,
				appointmentDate: document.getElementById('appointmentDate').value,
				appointmentTime: document.getElementById('appointmentTime').value
			}
			
			let appointments = JSON.parse(localStorage.getItem("appointments")) || [];
			appointments.push(appointment);
			localStorage.setItem("appointments", JSON.stringify(appointments));

			displayAppointments();
		});

		function displayAppointments() {

			let table = document.getElementById("appointmentTable");
			table.innerHTML = ""; // Clear existing table data

			let appointments = JSON.parse(localStorage.getItem("appointments")) || [];

			appointments.forEach(function(app) {
				let row = table.insertRow();

				row.insertCell(0).innerHTML = app.fullname;
				row.insertCell(1).innerHTML = "General Checkup";
				row.insertCell(2).innerHTML = app.appointmentDate;
				row.insertCell(3).innerHTML = app.appointmentTime;
			});
		}
		displayAppointments();
	</script>
</body>

</html>