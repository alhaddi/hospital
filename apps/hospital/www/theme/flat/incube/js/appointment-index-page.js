jQuery(function($) {
	"use strict";
	var Site = {

		initialized : false,

		initialize : function() {

			if (this.initialized)
				return;
			this.initialized = true;

			this.build();
			this.validation();

		},

		build : function() {
		},

		validation : function() {
			var bool = true;

			$('#name,#date,#email,#message,#mobile').blur(function() {
				validateForm2(this);
			});
			//====================================
			//==========Gander===============
			$('#gender').change(function() {
				var error = 0;
				var country = $('#gender').val();

				if (country == '0') {
					error = 1;
					$('#gender').addClass('error');
				} else {

					$('#gender').removeClass('error');
				}
			});

			//====================================
			//==========Select Speciality======
			$('#select_speciality').change(function() {
				var error = 0;
				var speciality = $('#select_speciality').val();

				if (speciality == '0') {
					error = 1;
					$('#select_speciality').addClass('error');
				} else {

					$('#select_speciality').removeClass('error');
				}
			});

			//====================================
			//==========select_doctor======
			$('#select_doctor').change(function() {
				var error = 0;
				var doctor_select = $('#select_doctor').val();

				if (doctor_select == '0') {
					error = 1;
					$('#select_doctor').addClass('error');
				} else {

					$('#select_doctor').removeClass('error');
				}
			});
			//====================================
			//===================Submit Function
			$('#submit').click(function() {
				var i = 0;
				var error = 0;
				var country = $('#gender').val();

				if (country == '0') {
					error = 1;
					$('#gender').addClass('error');
				} else {
					i++;
					$('#gender').removeClass('error');
					select_val = $('#gender').val();

				}

				//====================================
				//==========Select Speciality======
				
					var error = 0;
					var speciality = $('#select_speciality').val();

					if (speciality == '0') {
						error = 1;
						$('#select_speciality').addClass('error');
					} else {
						i++;
						$('#select_speciality').removeClass('error');
						speciality_val = $('#select_speciality').val();
					}
				
				//====================================
				//==========select_doctor======
				
					var error = 0;
					var doctor_select = $('#select_doctor').val();

					if (doctor_select == '0') {
						error = 1;
						$('#select_doctor').addClass('error');
					} else {
						i++;
						$('#select_doctor').removeClass('error');
						select_doctor_val = $('#select_doctor').val();
					}
				
				//====================================
				
				var x = $('#name').val();

				if (x == null || x == "" || x == "Name") {

					$('#name').addClass('error');
					bool = false;

				} else {
					i++;
					$('#name').removeClass('error');
					name_val = $('#name').val();

				}
				//====================================
				if (($('#mobile').val() != "" || $('#mobile').val() != null) && ($('#mobile').val().match(numericExpression))) {
					i++;
					$('#mobile').removeClass('error');
					mobile_val = $('#mobile').val();

				} else {

					$('#mobile').addClass('error');

				}
				//====================================
				var x = $('#date').val();

				if (x == null || x == "" || x == "Name") {
					$('#date').addClass('error');
					bool = false;

				} else {
					i++;
					$('#date').removeClass('error');
					date_val = $('#date').val();

				}
				//====================================
				var x = $('#email').val();

				var atpos = x.indexOf("@");
				var dotpos = x.lastIndexOf(".");
				if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length || x == 'Email') {
					$('#email').addClass('error');
					bool = false;
				} else {

					i++;
					$('#email').removeClass('error');
					email_val = $('#email').val();

				}
				//====================================
				if (i == 7) {
					bool = true;
				}

				if (!bool) {
					return false;
				} else {
					$.post('appointment-index-page.php', {
						name : name_val,
						gender : select_val,
						number : mobile_val,
						email : email_val,
						date : date_val,
						speciality: speciality_val, 
						select_doctor: select_doctor_val,
						
					}, function(data) {

						if (data == 1) {
							setTimeout(function() {
								$('#name').val('');
								$('#gender').val('');
								$('#email').val('');
								$('#message').val('');
								$('#date').val('');
								$('#select_speciality').val('');
								$('#select_doctor').val('');
								$('#mobile').val('');
								$('#success').fadeIn(500);

								$('#success').find('div').fadeIn();
								setTimeout(function() {
									$('#success').find('div').fadeOut();

								}, 2500)
							}, 500);

						}

					})
				}

			});

			function validateForm2(abc) {

				if ($(abc).val() != "") {
					$(abc).removeClass('error');

				} else {
					$(abc).addClass('error');

				}
				//email
				if ($(abc).attr('id') == 'email') {
					if (($(abc).val() != "" || $(abc).val() != null) && ($(abc).val().match(emailRegex))) {
						$(abc).removeClass('error');

					} else {
						$(abc).addClass('error');
					}
				}

				if ($(abc).attr('id') == 'mobile') {
					if (($(abc).val() != "" || $(abc).val() != null) && ($(abc).val().match(numericExpression))) {
						$(abc).removeClass('error');

					} else {
						$(abc).addClass('error');
					}
				}

			}

			var name_val = ''
			var select_val = '';
			var mobile_val = ''
			var email_val = '';
			var date_val = '';
			var speciality_val  = '';
			var select_doctor_val = '';
			var msg_val = '';
			var comp_val = '';
			var emailRegex = /^[a-zA-Z0-9._]+[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/;
			var numericExpression =   /^[0-9]+$/;

		}
	};

	Site.initialize();
})

