<script>
    var canvas = document.getElementById("application");
    var ctx = canvas.getContext("2d");

    var img = new Image();
    img.src = 'images/file_icon.png';

    var selected_context_menu_file = -1;
    var selected_file = -1;

	document.addEventListener('mousemove', pointer_stats);
	document.addEventListener('mousedown', switch_drag);
	document.addEventListener('mouseup', switch_drag);

    var pointer = {
        is_dragging: false,
        click_position_x: 0,
        click_position_y: 0,
        pointer_position_x: 0,
        pointer_position_y: 0
    };

    const files = [
        <?php
            foreach($files as $item){
        ?>
        {
            filename: "<?php echo $item['file_name']; ?>",
            position_x: <?php echo $item["position_x"] ?>,
            position_y: <?php echo $item["position_y"] ?>
        },
        <?php
            }
        ?>
    ];

    refresh();
    function refresh(){
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        ctx.fillStyle = "#000000";
        ctx.fillRect(0,0,window.innerWidth,window.innerHeight);
        ctx.fillStyle = "#303030";
        ctx.font = "28px Arial";
        ctx.fillText("<?php echo $_SESSION['username']; ?>'s desktop", 20, 40);

        files.forEach(item => {
            ctx.drawImage(img, item.position_x, item.position_y, 70, 100);
            ctx.fillStyle = "#111111";
            ctx.font = "16px Arial";
            ctx.fillText(item.filename.split(".")[1], item.position_x + 5, item.position_y + 15);
            
            ctx.fillStyle = "#FFFFFF";
            ctx.font = "20px Arial";
            ctx.fillText(item.filename.split("_")[1], item.position_x, item.position_y + 130);
        });

        if(selected_context_menu_file != -1){
            ctx.font = "16px Arial";

            if(pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + 100 && pointer.pointer_position_y >= pointer.click_position_y && pointer.pointer_position_y <= pointer.click_position_y + 30)
                ctx.fillStyle = "#DFDFDF";
            else
                ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(pointer.click_position_x, pointer.click_position_y, 100, 30);
            ctx.fillStyle = "#999999";
            ctx.fillText("Delete", pointer.click_position_x + 5, pointer.click_position_y + 20);
            ctx.rect(pointer.click_position_x, pointer.click_position_y, 100, 30);

            if(pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + 100 && pointer.pointer_position_y >= pointer.click_position_y + 30 && pointer.pointer_position_y <= pointer.click_position_y + 60)  
                ctx.fillStyle = "#DFDFDF";
            else
                ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(pointer.click_position_x, pointer.click_position_y + 30, 100, 30);
            ctx.fillStyle = "#999999";
            ctx.fillText("Rename", pointer.click_position_x + 5, pointer.click_position_y + 50);
            ctx.rect(pointer.click_position_x, pointer.click_position_y + 30, 100, 30);

            ctx.stroke();
        }
    }
        
    function pointer_stats(e){
        pointer.pointer_position_x = e.clientX;
        pointer.pointer_position_y = e.clientY;

        if(pointer.is_dragging){
            if(selected_file != -1){
                files[selected_file].position_x = pointer.pointer_position_x - (75 / 2);
                files[selected_file].position_y = pointer.pointer_position_y - (100 / 2);
            }
        }

        refresh();
    }
    function switch_drag(){
        pointer.is_dragging = !pointer.is_dragging;

        pointer.click_position_x = pointer.pointer_position_x;
        pointer.click_position_y = pointer.pointer_position_y;

        for(let i = 0; i < files.length; i++){
            if(pointer.click_position_x > files[i].position_x && pointer.click_position_x < files[i].position_x + 75){
                if(pointer.click_position_y > files[i].position_y && pointer.click_position_y < files[i].position_y + 100){
                    if(pointer.is_dragging && selected_file == -1){
                        selected_file = i;
                        break;
                    }
                }
            }
        }
        
        if(!pointer.is_dragging){
            if(selected_file != -1){
                save_desktop_fn();
            }
            selected_file = -1;
            selected_context_menu_file = -1;
        }
        
        refresh();
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

    function save_desktop_fn(){
        files.forEach(item => {
            var form_data = new FormData();
            form_data.append('filename', item.filename);
            form_data.append('position_x', item.position_x);
            form_data.append('position_y', item.position_y);

            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "save_desktop.php", true);
            xhttp.send(form_data);
        });
    }

    function open_file(){
        for(let i = 0; i < files.length; i++){
            if(pointer.click_position_x > files[i].position_x && pointer.click_position_x < files[i].position_x + 75){
                if(pointer.click_position_y > files[i].position_y && pointer.click_position_y < files[i].position_y + 100){
                    window.open("uploads/"+files[i].filename, "_blank");
                    break;
                }
            }
        }
    }

    window.addEventListener('contextmenu', (event) => {
        event.preventDefault();

        for(let i = 0; i < files.length; i++){
            if(pointer.click_position_x > files[i].position_x && pointer.click_position_x < files[i].position_x + 75){
                if(pointer.click_position_y > files[i].position_y && pointer.click_position_y < files[i].position_y + 100){
                    selected_context_menu_file = i;
                    break;
                }
            }
        }
        
        refresh();
    });
</script>
