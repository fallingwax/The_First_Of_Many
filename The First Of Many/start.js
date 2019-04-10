var i = 0;
var speed = 100; 

var txt = 
    "How did this happen? The day started out so,    normal. I woke up, got dressed, yelled at the kid crossing the street not paying attention. I sat in traffic on the way to work. I got to work and everything was fine. Then the power went. Not the kind of thing that happens all the time but it didn't seem unusual. The power flashed back on as if it was never off in the first place. But all of the computers were dead, the internet was out and no one could use their cell phones. It could have been a lightning strike I guess. There was a thunderstorm a few towns over and maybe lightning hit a cell tower, but that still doesn't explain all of the computers being out.  Everyone was in a panic, running around confused and unsure of what happened.  We tried to leave but the car's wouldn't start. Except Mary's car... she's had that thing forever and it doesn't have any computer components.";
    
    


function typeWriter() {
  if (i < txt.length) {
    document.getElementById("start").innerHTML += txt.charAt(i);
    i++;
    setTimeout(typeWriter, speed);
  }
}
        
typeWriter();