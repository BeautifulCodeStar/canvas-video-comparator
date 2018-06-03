<html>
    <head>
        <title>Video comparator tool</title>
        <link rel="stylesheet" id="fontawesome-css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" type="text/css" media="all">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div style="width:100%;height:50% auto;">
            <canvas id="videoMerge" width="630" height="800">
            </canvas>
        </div>
        
        <div id="video-compare-container">
            <video muted autoplay="autoplay" playsinline loop id="rightVideo">
                <source src="assets/videos/video-1.mp4">    
            </video>
            <video muted autoplay="autoplay" playsinline loop id="leftVideo">
                <source src="assets/videos/video-2.mp4">
            </video>
        </div>

        <div id="over_video">
            <span class="big-icon" id="exec">
                <i class="fa fa-play"></i>
            </span>
            <p>
                Canvas Video<br>Comparator
            </p>
        </div>
    </body>
    <script>
        
        var videoContainer = document.getElementById("video-compare-container"),
        videoUI = document.getElementById("videoUI"),
        videoMerge = document.getElementById("videoMerge"),
        leftVideo = document.getElementById("leftVideo"),
        rightVideo = document.getElementById("rightVideo"),
        overWrite = document.getElementById("over_video"),
        videoControl = document.querySelector('#exec'),
        position = 0.5,
        vidHeight = 800,
        vidWidth = 630;
        mergeContext = videoMerge.getContext("2d");
        videoContainer.style.display = "none";
        videoControl.addEventListener("click", playPause, false);

        function playPause() {
            if (leftVideo.paused) {
                playVids();
            } else {
                leftVideo.pause();
                rightVideo.pause();
            }
        }
        setTimeout(() => {
            playVids();
        }, 1000);

    function playVids() {
        if (leftVideo.readyState > 3 && rightVideo.readyState > 3) {
            leftVideo.play();
            rightVideo.play();
            
            function trackLocation(e) {
                position = ((e.pageX - videoMerge.offsetLeft) / videoMerge.offsetWidth);
                if (position <= 1 && position >= 0) {
                    leftVideo.volume = position;
                    rightVideo.volume = (1 - position);
                }
            }
            
            videoMerge.addEventListener("mousemove", trackLocation, false); 
            videoMerge.addEventListener("touchstart",trackLocation,false);
            videoMerge.addEventListener("touchmove",trackLocation,false);
            overWrite.addEventListener("mousemove",trackLocation,false);
            overWrite.addEventListener("touchstart",trackLocation,false);
            overWrite.addEventListener("touchmove",trackLocation,false);
            // videoMerge.addEventListener("resize",trackLocation,false);
            
            function drawLoop() {
                mergeContext.drawImage(leftVideo, 0, 0, vidWidth, vidHeight, 0, 0, vidWidth, vidHeight);
                mergeContext.drawImage(rightVideo, 
                (vidWidth * position).clamp(0.01,vidWidth), 0,
                (vidWidth - (vidWidth * position)).clamp(0.01,vidWidth),
                vidHeight,(vidWidth * position).clamp(0.01,vidWidth), 0,
                (vidWidth - (vidWidth * position)).clamp(0.01,vidWidth), vidHeight);
                    requestAnimationFrame(drawLoop);
            }
            requestAnimationFrame(drawLoop);
        }
    }

    

    Number.prototype.clamp = function(min, max) {
        return Math.min(Math.max(this, min), max);
    };

    </script>
</html>