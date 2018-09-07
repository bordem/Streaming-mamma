function mk_dialog(){
	function add_close_btn(elem){
		var btn = document.createElement("input");
		btn.type="button";
		btn.classList.add("closeBtn");
		btn.value="⨉";
		btn.addEventListener('click', function(){
			elem.style.display="none";
		});
		elem.appendChild(btn);
	}
	document.querySelectorAll('.info,.error').forEach(function(elem){
		console.log(elem);
		add_close_btn(elem);
	});
}


window.addEventListener('load',mk_dialog);
