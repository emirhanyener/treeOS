<script>
    var canvas = document.getElementById("application");
    var ctx = canvas.getContext("2d");

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    ctx.fillStyle = "#000000";
    ctx.fillRect(0,0,window.innerWidth,window.innerHeight);
    ctx.fillStyle = "#FFFFFF";
    ctx.fillRect(10,10,75,100);
    ctx.font = "20px Arial";
    ctx.fillText("file_name", 10, 140);
</script>