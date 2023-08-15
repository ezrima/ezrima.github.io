	<h2 class="text-center">Understanding Objects Like Humans</h2>
	<h3 class="text-center">Learn to identify objects by compareing them (like humans) </h3>
	<form>
		<?php
		echo form_label('Learn how to distinguish a object:');
		$attr['placeholder'] = 'Enter first object here...such as monkey...';
		$attr['id'] = 'primary-object';
		echo form_input('primary_object', '', $attr);
		echo form_label("from another object");
		$attr2['placeholder'] = 'Enter second object here... such as human...';
		$attr2['id'] = 'secondary-object';
		echo form_input('secondary_object', '', $attr2);
		$btn_attr['onclick'] = 'fetchTutorial()';
		echo form_button('submit', 'Search',$btn_attr);
		?>
	</form>
	<div class="spinner" style="display:none"></div>
	<div id="post">
		<p class="text-center"></p>
	</div>

	<style type="text/css">
		form {
			max-width: 420px;
			margin: 0 auto;
		}
		.spinner{
			min-height: 7em;
		}
		h3{

			font-weight: normal;
			font-size: 85%;
		}
		#info-div {
			margin: 3em;
		}
	</style>
	<script type="text/javascript">
		const origObjectEl = document.getElementById('primary-object');
		const origObject2El = document.getElementById('secondary-object');
		const theForm = document.getElementsByTagName('form')[0];
		const spinner = document.getElementsByClassName('spinner')[0];
		const tutorialEl= document.getElementsByTagName('p')[0];
		const storyEl = document.getElementById('post');


		function fetchTutorial(){


			if (origObjectEl.value !== '') {
				//remove the info-div, if it exists
				const infoDiv = document.getElementById('info-div');
				if(infoDiv){
					infoDiv.remove();
				}

			//hide the form
				theForm.style.display ='none';
				//display the spinner
				spinner.style.display='flex';

				//fetch a tutorial from the API endpoint
				const targetUrl ='<?= BASE_URL ?>api/create/posts';
				const params = {
					primary_object: origObjectEl.value,
					secondary_object: origObject2El.value
				}


				const http = new XMLHttpRequest();
				http.open('post', targetUrl);
				http.setRequestHeader('Content-type', 'application/json');
				http.send(JSON.stringify(params));
				http.onload = function(){
					if(http.status !== 200){
						handleError(http.responseText);
					} else{
						drawTutorial(http.responseText);
					}
				}



			}

		}

		function handleError(errorMsg){
			alert(errorMsg);
				//display the form
			theForm.style.display ='block';
				//hide the spinner
			spinner.style.display='none';
				//clear the form field
			origObjectEl.value = '';

		}

		function drawTutorial(jsonStr){

			const tutorText = JSON.parse(jsonStr);

			tutorialEl.innerHTML=tutorText.tutorial;
			//display the form
			theForm.style.display ='block';
			//hide the spinner
			spinner.style.display='none';

			//generate image
			generateImage(origObjectEl.value, origObject2El.value,  tutorText.id);
	        //clear the form field
			origObjectEl.value = '';
			origObject2El.value = '';

		}

		function generateImage(object1Text,objext2Text, updatedId){

			//create an info div
			const infoDiv = document.createElement('div');
			infoDiv.setAttribute('id', 'info-div');
			infoDiv.setAttribute('class', 'text-center blink');
			infoDiv.innerHTML= '* LOADING PICTURE - PLEASE WAIT *';

			storyEl.insertBefore(infoDiv,tutorialEl);

			//send the actiontext and updated Id to custom API
			const targetUrl = '<?= BASE_URL ?>posts/init_gen_com_image';
			const joinedMsg = [object1Text,' and ',objext2Text].join('');
			//build an obj containing picture we want to post
			const params = {
				updatedId,
				joinedMsg
				

			}

			//create the HTTP post request
			const http = new XMLHttpRequest();
			http.open('post', targetUrl);
			http.setRequestHeader('Content-type', 'application/json');
			http.send(JSON.stringify(params));
			http.onload = function(){
				if(http.status !== 200){
					handleError(http.responseText);
				} else{
					drawImage(http.responseText);

				}
			}

		}

		function drawImage(picPath){
			const infoDiv = document.getElementById('info-div');
			infoDiv.innerHTML='';
			infoDiv.classList.remove('blink');

			
			//create an img on the page
			const newPic = document.createElement('img');
			newPic.setAttribute('src', picPath);
			infoDiv.appendChild(newPic);


		}
	</script>