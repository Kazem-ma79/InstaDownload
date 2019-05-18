function download() {
	let id = {"media_id": $("#media_id").val()};
	if (id == '') return;
	$("#gallery").html("");
	$('input[type = "submit"]').val("Downloading...");
	$('input[type = "submit"]').removeClass("view-theme").addClass("download-theme");
	var xhr = new XMLHttpRequest();
	var url = "/insta download/api/api.php";
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			var response = JSON.parse(xhr.responseText);
      if (response.status == "failed") {
        $("#gallery").prepend('<div class="gallery"><img src="images/failed.jpg" alt="Failed" width="600" height="400"></div>');
      }
      else {
        let data = response.data;
        let mode = data.mode;
        if(mode == "single") {
					if(data.posts.type == "photo")
          	$("#gallery").append('<div class="gallery"><a target="_blank" href="' + data.posts.url + '"><img src="' + data.posts.url + '" width="600" height="400"></a></div>');
					else
						$("#gallery").append('<div class="gallery"><a target="_blank" href="' + data.posts.url + '"><img src="' + data.posts.thumb + '" width="600" height="400"></a></div>');
        }
        else {
					for (var i = 0; i < data.posts.length; i++) {
						let currentPost = data.posts[i];
						if(currentPost.type == "photo")
	          	$("#gallery").append('<div class="gallery"><a target="_blank" href="' + currentPost.url + '"><img src="' + currentPost.url + '" width="600" height="400"></a></div>');
						else
							$("#gallery").append('<div class="gallery"><a target="_blank" href="' + currentPost.url + '"><img src="' + currentPost.thumb + '" width="600" height="400"></a></div>');
					}
				}
      }
		}
		$('input[type = "submit"]').val("View & Download");
		$('input[type = "submit"]').removeClass("download-theme").addClass("view-theme");
	};
	var data = JSON.stringify({"media_id": $("#media_id").val()});
	xhr.send(data);
}
