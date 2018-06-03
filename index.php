<html>
    <head>
        <title>Video comparator tool</title>
        <link rel="stylesheet" id="fontawesome-css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" type="text/css" media="all">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
      
        <canvas id="videoMerge" width="1024" height="576">
        </canvas>
        
        <div id="video-compare-container">
            <video muted autoplay="autoplay" id="rightVideo">
                
                <source src="assets/videos/video-1.mp4">    
            </video>
            <video muted autoplay="autoplay" id="leftVideo">
                <source src="assets/videos/video-2.mp4">
            </video>
        </div>

        <div id="over_video">
            <span class="big-icon" onclick="play()">
                <i class="fa fa-play"></i>
            </span>
            Canvas Video<br>Comparator
        </div>

        
        <!-- <div id="videoUI"></div> -->
    </body>
    <script>
        
        var videoContainer = document.getElementById("video-compare-container"),
        videoUI = document.getElementById("videoUI"),
        videoMerge = document.getElementById("videoMerge"),
        leftVideo = document.getElementById("leftVideo"),
        rightVideo = document.getElementById("rightVideo"),
        videoControl = document.createElement("button"),
        position = 0.5,
        vidHeight = 576,
        vidWidth = 1024;
        mergeContext = videoMerge.getContext("2d");
        videoContainer.style.display = "none";
        videoControl.innerHTML = "Play";
        videoUI.appendChild(videoControl); 
        videoControl.addEventListener("click", playPause, false);

        function playPause() {
            if (leftVideo.paused) {
                videoControl.innerHTML = "Pause";
                playVids();
            } else {
                leftVideo.pause();
                rightVideo.pause();
                videoControl.innerHTML = "Play";
            }
        }

    function playVids() {
        if (leftVideo.readyState > 3 && rightVideo.readyState > 3) {
            leftVideo.play();
            rightVideo.play();

            function trackLocation(e) {
                position = ((e.pageX - videoMerge.offsetLeft) / videoMerge.offsetWidth);
                // if (position <= 1 && position >= 0) {
                //     leftVideo.volume = position;
                //     rightVideo.volume = (1 - position);
                // }
            }
            
            videoMerge.addEventListener("mousemove", trackLocation, false); 
            videoMerge.addEventListener("touchstart",trackLocation,false);
            videoMerge.addEventListener("touchmove",trackLocation,false);

            function drawLoop() {
                mergeContext.drawImage(leftVideo, 0, 0, vidWidth, vidHeight,
                0, 0, vidWidth, vidHeight);
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

    playVids();

    Number.prototype.clamp = function(min, max) {
        return Math.min(Math.max(this, min), max);
    };

    </script>
</html>