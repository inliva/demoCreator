jQuery(function($){
		
		Dropzone.autoDiscover = false;
		Dropzone.options.filedrop = {
		  
		};
		try {
		  var myDropzone = new Dropzone("#dropzone" , {
		  	init: function () {
			    this.on("complete", function (file) {
			    	if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
			      		$.ajax({
			      			type: 'GET',
			      			url: 'paket.php',

			      			success: function(msg){
			      				alert(msg)
			      			},
			      		});
			      	}
			    });
			},
		    
		    paramName: "file", // The name that will be used to transfer the file
		    maxFilesize: 5, // MB
		
			addRemoveLinks : true,
			dictDefaultMessage :
			'<span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> Dosyaları</span> sürükleyip bırakın \
			<span class="smaller-80 grey">(yada tıklayın)</span> <br /> \
			<i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>',
			dictResponseError: 'Error while uploading file!',
			
			//change the previewTemplate to use Bootstrap progress bars
			previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <im data-dz-thumbnil />\n  </div>\n  <div class=\"progress progress-small progress-striped active\"><div class=\"progress-bar progress-bar-success\" data-dz-uploadprogress></div></div>\n  <div class=\"dz-success-mark\"><span></span></div>\n  <div class=\"dz-error-mark\"><span></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>"
		  });

		} catch(e) {
		  alert('Dropzone.js does not support older browsers!');
		}
		
		});