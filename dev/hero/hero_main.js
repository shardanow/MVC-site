
// Copyright 2011 William Malone (www.williammalone.com)
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//   http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

var canvas;
var context;
var images = {};
var totalResources = 11;
var numResourcesLoaded = 0;
var fps = 30;
var x = 85;
var y = 185;
var breathInc = 0.1;
var breathDir = 1;
var breathAmt = 0;
var breathMax = 2;
var breathInterval = setInterval(updateBreath, 1000 / fps);
var maxEyeHeight = 14;
var curEyeHeight = maxEyeHeight;
var eyeOpenTime = 0;
var timeBtwBlinks = 4000;
var blinkUpdateTime = 200;                    
var blinkTimer = setInterval(updateBlink, blinkUpdateTime);
var fpsInterval = setInterval(updateFPS, 1000);
var numFramesDrawn = 0;
var curFPS = 0;
var emotion = false;
var emotion1 = false;
var mess_box = false;
var timer = 1;

function updateFPS() {
	
	curFPS = numFramesDrawn;
	numFramesDrawn = 0;
}		
function prepareCanvas(canvasDiv, canvasWidth, canvasHeight)
{
	// Create the canvas (Neccessary for IE because it doesn't know what a canvas element is)
	canvas = document.createElement('canvas');
	canvas.setAttribute('width', canvasWidth);
	canvas.setAttribute('height', canvasHeight);
	canvas.setAttribute('id', 'canvas');
	canvasDiv.appendChild(canvas);
	
	if(typeof G_vmlCanvasManager != 'undefined') {
		canvas = G_vmlCanvasManager.initElement(canvas);
	}
	context = canvas.getContext("2d"); // Grab the 2d canvas context
	// Note: The above code is a workaround for IE 8and lower. Otherwise we could have used:
	//     context = document.getElementById('canvas').getContext("2d");
	
	loadImage("leftArm");
	loadImage("legs");
	loadImage("torso");
	loadImage("rightArm");
    loadImage("rightArm_laugh");
    loadImage("rightArm_mess");
	loadImage("head");
    loadImage("mouth");
    loadImage("mouth_act");
    loadImage("mouth_laugh");
	loadImage("hair");
    loadImage("eyes_act");
}

function loadImage(name) {

  images[name] = new Image();
  images[name].onload = function() { 
	  resourceLoaded();
  }
  images[name].src = "../hero/images/" + name + ".png";
}

function resourceLoaded() {

  numResourcesLoaded += 1;
  if(numResourcesLoaded === totalResources) {
  
	setInterval(redraw, 1000 / fps);
  }
}

function redraw() {
				
  canvas.width = canvas.width; // clears the canvas 

    drawEllipse(x + 28, y +84, 100 - breathAmt, 5); // Shadow

    context.drawImage(images["leftArm"], x , y -20 - breathAmt);
    context.drawImage(images["legs"], x-4, y+33);

    if (emotion1)
    {
        context.drawImage(images["rightArm_laugh"], x + 48, y - 20 - breathAmt);
    }
    else if (mess_box)
    {
        context.drawImage(images["rightArm_mess"], x + 52, y - 48 - breathAmt);
        if(timer==1)
        {
            var audio = new Audio("../hero/mess.mp3");
            audio.play();
            timer=0;
        }
    }
    else
    {
        context.drawImage(images["rightArm"], x + 48, y - 25 - breathAmt);
    }

    context.drawImage(images["torso"], x -12, y - 41- breathAmt);
    context.drawImage(images["head"], x - 10, y - 125 - breathAmt);
    context.drawImage(images["hair"], x - 68, y - 145 - breathAmt);
    if (emotion1)
    {
        context.drawImage(images["mouth_laugh"], x +20, y - 48 - breathAmt);
    }
    else if (emotion)
    {
        context.drawImage(images["mouth_act"], x +20, y - 48 - breathAmt);
    }
    else
    {
        context.drawImage(images["mouth"], x +20, y - 48 - breathAmt);
    }


    if (emotion1)
    {
        context.drawImage(images["eyes_act"], x -8, y - 73 - breathAmt);
        if(timer==1)
        {
            var audio = new Audio("../hero/laugh.mp3");
            audio.play();
            timer=0;
        }

    }
    else if (emotion)
    {
       context.drawImage(images["eyes_act"], x -8, y - 73 - breathAmt);
        if(timer==1)
        {
            var audio = new Audio("../hero/ou.mp3");
            audio.play();
            timer=0;
        }
    }
    else
    {
        drawEllipse(x + 10, y - 61 - breathAmt, 18, curEyeHeight, "black"); // Left Eye
        drawEllipse(x + 40, y - 62 - breathAmt, 18, curEyeHeight, "black"); // Right Eye
        drawEllipse(x + 10, y - 60 - breathAmt, 18, curEyeHeight, "white"); // Left Eye
        drawEllipse(x + 40, y - 61 - breathAmt, 18, curEyeHeight, "white"); // Right Eye
        drawEllipse(x + 12, y - 60 - breathAmt, 16, curEyeHeight+1, "#d88cc6"); // Left Eye
        drawEllipse(x + 42, y - 61 - breathAmt, 16, curEyeHeight+1, "#d88cc6"); // Right Eye
        drawEllipse(x + 12, y - 61 - breathAmt, 13, curEyeHeight, "#6f4386"); // Left Eye
        drawEllipse(x + 42, y - 62 - breathAmt, 13, curEyeHeight, "#6f4386"); // Right Eye
        drawEllipse(x + 10, y - 62 - breathAmt, 8, curEyeHeight-8, "white"); // Left Eye
        drawEllipse(x + 40, y - 63 - breathAmt, 8, curEyeHeight-8, "white"); // Right Eye
    }

    //context.font = "bold 12px sans-serif";
    //context.fillStyle = "black";
  //context.fillText("fps: " + curFPS + "/" + fps + " (" + numFramesDrawn + ")", 40, 20);
    //context.fillText("Animation test | D.S.", 40, 10);
  ++numFramesDrawn;
}

function drawEllipse(centerX, centerY, width, height, color) {

  context.beginPath();
  
  context.moveTo(centerX, centerY - height/2);

  context.bezierCurveTo(
	centerX + width/2, centerY - height/2,
	centerX + width/2, centerY + height/2,
	centerX, centerY + height/2);

  context.bezierCurveTo(
	centerX - width/2, centerY + height/2,
	centerX - width/2, centerY - height/2,
	centerX, centerY - height/2);
 
  context.fillStyle = color;
  context.fill();
  context.closePath();	
}

function updateBreath() { 
				
  if (breathDir === 1) {  // breath in
	breathAmt -= breathInc;
	if (breathAmt < -breathMax) {
	  breathDir = -1;
	}
  } else {  // breath out
	breathAmt += breathInc;
	if(breathAmt > breathMax) {
	  breathDir = 1;
	}
  }
}

function updateBlink() { 
				
  eyeOpenTime += blinkUpdateTime;
	
  if(eyeOpenTime >= timeBtwBlinks){
	blink();
  }
}

function blink() {

  curEyeHeight -= 1;
  if (curEyeHeight <= 0) {
	eyeOpenTime = 0;
	curEyeHeight = maxEyeHeight;
  } else {
	setTimeout(blink, 10);
  }
}

function emo() {
    if (!emotion) {
        emotion = true;
        setTimeout(normal, 1000);
    }
}

function emo1() {
    if (!emotion1) {
        emotion1 = true;
        setTimeout(normal, 7000);
    }
}

function normal() {
    emotion = false;
    emotion1 = false;
    mess_box =  false;
    timer=1;
}

function message_box() {
    if (!mess_box) {
        mess_box = true;
        setTimeout(normal, 7000);
    }
}