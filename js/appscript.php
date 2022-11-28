
<script>
    var canvas = document.getElementById("application");
    var ctx = canvas.getContext("2d");

    var pointer = {
        is_dragging: false,
        pointer_position_x: 0,
        pointer_position_y: 0
    };

    const files = [
        <?php
            foreach($files as $item){
        ?>
        {
            filename: "<?php echo $item['file_name'] ?>",
            position_x: <?php echo $item["position_x"] ?>,
            position_y: <?php echo $item["position_y"] ?>
        },
        <?php
            }
        ?>
    ];


	document.addEventListener('mousemove', pointer_stats);
	document.addEventListener('mousedown', switch_drag);
	document.addEventListener('mouseup', switch_drag);

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    ctx.fillStyle = "#000000";
    ctx.fillRect(0,0,window.innerWidth,window.innerHeight);
    files.forEach(item => {
        ctx.fillStyle = "#FFFFFF";
        ctx.fillRect(item.position_x, item.position_y, 75, 100);
        ctx.font = "20px Arial";
        ctx.fillText(item.filename, item.position_x, item.position_y + 130);
    });
        
    function pointer_stats(e){
        pointer.pointer_position_x = e.clientX;
        pointer.pointer_position_y = e.clientY;
        console.log(pointer);
    }
    function switch_drag(){
        pointer.is_dragging = !pointer.is_dragging;
    }
    
    function drop(e){
        e.preventDefault();
        file_obj = e.dataTransfer.files[0];
        var form_data = new FormData();                  
        form_data.append('file', file_obj);
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "file_upload.php", true);
        xhttp.onload = function(event) {
            window.location.href = "desktop.php";
        }
 
        xhttp.send(form_data);
    }
    function allow_drop(e){
        e.preventDefault();
    }
</script>
