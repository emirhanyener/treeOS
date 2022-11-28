
<script>
    var canvas = document.getElementById("application");
    var ctx = canvas.getContext("2d");

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
