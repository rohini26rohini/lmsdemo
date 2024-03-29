CKEDITOR.plugins.add( 'simage', {
	icons: 'simage',
	allowedContent: 'img[alt,!src,width,height,data-width,data-height]{border-style,border-width,float,height,margin‌​,margin-bottom,margi‌​n-left,margin-right,‌​margin-top,width}',
	init: function( editor ) {
		editor.addCommand('simage', {
			exec: function (editor) {
				a = document.createElement('input')
				a.setAttribute('type','file')
				a.setAttribute('accept', '.jpg,.jpeg,.png,.tif,.gif,.svg')
				a.click()
				a.onchange = function(){
					file = a.files[0];
					$(CKEDITOR.currentInstance).trigger('enableFormSubmit')
					curr = CKEDITOR.currentInstance
					if (file.size > 5000000){
						b = document.createElement('div')
						b.className = 'message alert alert-danger'
						m = document.createElement('span')
						m.innerHTML = "Image size exceeded! Please upload image of less than 5 MB."
						b.appendChild(m)
						c = document.createElement('span')
						c.className = 'close'
						c.innerHTML = 'X'
						b.appendChild(c)
						e = document.querySelector('.error-space')
						e.appendChild(b)
						setTimeout(function(){ 
							alert = document.querySelector('.alert-danger')
							alert.parentNode.removeChild(alert)
						}, 20000)
						c.onclick = function(){
							b = document.querySelector('.alert-danger')
							b.parentNode.removeChild(b)
						} 
						$(CKEDITOR.instances[curr.name]).trigger('enableFormSubmit')
						return
					}else if (['jpeg','jpg','png','svg','gif','tif', 'svg+xml'].indexOf(file.type.split('/')[1]) === -1){
						b = document.createElement('div')
						b.className = 'message alert alert-danger'
						m = document.createElement('span')
						m.innerHTML = "The uploaded image format is not of acceptible format! Please upload an image!"
						b.appendChild(m)
						c = document.createElement('span')
						c.className = 'close'
						c.innerHTML = 'X'
						b.appendChild(c)
						e = document.querySelector('.error-space')
						e.appendChild(b)
						setTimeout(function(){ 
							alert = document.querySelector('.alert-danger')
							alert.parentNode.removeChild(alert)
						}, 20000)
						c.onclick = function(){
							b = document.querySelector('.alert-danger')
							b.parentNode.removeChild(b)
						} 
						$(CKEDITOR.instances[curr.name]).trigger('enableFormSubmit')
						return
					}
					img = new Image()
					img.onload = function(){
						inputWidth = this.width
						inputHeight = this.height
					}
					img.src = window.URL.createObjectURL(file)
					formData = new FormData;
					formData.append('file', file);
					loaderElem = new CKEDITOR.dom.element('loader-elem')
					loaderHtmlStr = '<div style="position: relative; z-index: 100;width: 100%;height: 100%;text-align: center;background: white;opacity: 0.75;pointer-events:none">' + '<div style="width: 100%;height: 30px;margin-top: 100px;">Please wait while image is uploading...</div>' + '</div>'
					loaderDomEle = CKEDITOR.dom.element.createFromHtml(loaderHtmlStr)
					loaderElem.append(loaderDomEle)
					editor.insertElement(loaderElem)
					CKEDITOR.currentInstance.setReadOnly(true)
					gbs_upload(editor,file,CKEDITOR)
				}
			}
		});

		editor.ui.addButton( 'SImage', {
			label: 'Custom Image Uploader',
			command: 'simage',
			toolbar: 'insert'
		});
	}
});

function gbs_upload(editor,file,CKEDITOR){
	var reader = new FileReader();
	reader.onloadend = function() {
		var inputWidth = 1366
		var inputHeight = 768
		url = reader.result;
		CKEDITOR.instances[curr.name].setReadOnly(false)
		elem = new CKEDITOR.dom.element( 'elem' )
		maxWidth = Math.min(inputWidth, 600)
		maxHeight = Math.min(inputHeight, 600)
		if ((maxWidth/maxHeight) > (inputWidth/inputHeight)){
			width = (maxWidth * inputWidth)/inputHeight
			height = maxHeight
		} else if ((maxWidth/maxHeight) < (inputWidth/inputHeight)){
			width = maxWidth
			height = (maxHeight * inputHeight)/inputWidth
		} else{
			width = maxWidth
			height = maxHeight
		}
		newLine = CKEDITOR.dom.element.createFromHtml('<p><br></p>')	
		// imgElem = '<img src="' + url + '" class="image-editor" data-width="' + inputWidth + '" data-height="' + inputHeight + '" height="' + height + '" width="' + width + '">'
		imgElem = '<img style="max-width: 100%;max-height: 100%;height: auto !important;" src="' + url + '" class="image-editor" data-width="' + inputWidth + '" data-height="' + inputHeight + '" height="' + height + '" width="' + width + '">'
		imgDomElem = CKEDITOR.dom.element.createFromHtml(imgElem)
		elem.append(imgDomElem)
		editor.insertElement(newLine)
		editor.insertElement(elem)
		editor.insertElement(newLine)
		loaderElem.remove()
		$(CKEDITOR.instances[curr.name]).trigger('enableFormSubmit')
	}
	reader.readAsDataURL(file);
}