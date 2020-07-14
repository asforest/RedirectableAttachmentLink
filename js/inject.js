setTimeout(function(){
	window.Typecho.uploadComplete = function (file) { } // 阻止默认的插入链接行为

	var readyToReplace = false // 防止多次触发

	function replaceListener() // 劫持原有的监听器
	{
		$('#file-list li .insert').unbind("click") // 接触原有的监听器
		$('#file-list li .insert').click(function (e) { // 换上自己的
			e.preventDefault() // 防止打开附件链接

			var t = $(this)
			var p = t.parents('li');
			var domain = location.origin
			Typecho.insertFileToEditor(t.text(), domain + "/attach/" + p.data('cid'), p.data('image'));
		});
	}

	replaceListener() // 对列表中已有的项目进行劫持

	$("#file-list").bind("DOMNodeInserted", function(){ // 对新加入的项目进行劫持
		if(!readyToReplace)
		{
			readyToReplace = true
			setTimeout(function(){
				replaceListener()
				readyToReplace = false
			}, 100)
		}
		
	});  

}, 1000)