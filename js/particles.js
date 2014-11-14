// Get the canvas DOM element along with it's 2D context
// which is basically what we do our work on

var canvas = document.getElementById('particle-canvas'),
		ctx = canvas.getContext('2d'),
		window_width = canvas.width,//window.innerWidth,
		window_height = canvas.height;//window.innerHeight;

// Set canvas's width and height to that
// of window (the view port)
//canvas.width = window_width;
//canvas.height = window_height;

// Just a random object name to store some utility
// functions that we can use later
var $$ = {
	// Get a random integer from a range of ints
	// Usage: $$.randomInt(4, 8) -> would return
	// 4 or 5 or 6 or 7 or 8
	randomInt: function(min, max) {
		return Math.floor( Math.random() * (max - min + 1) + min );
	}
};

// Pool of particles. Basically an array that stores all
// our particles
var particles = [];

// The object that'll serve as the prototype
// of every particle we create!
var Particle = {
	x: window_width/2,
	y: window_height/2,
	x_speed: 10,
	y_speed: 10,
	radius: 10,
	_position: {},

	// Draw the particle
	draw: function() {
		// Begin Drawing Path
		ctx.beginPath();
		// Background color for the object that we'll draw
		ctx.fillStyle = this.bg_color;
		// Draw the arc
		// ctx.arc(x, y, radius, start_angle, end_angle, anticlockwise)
		// angle are in radians
		// 360 degrees = 2π radians or 1 radian = 360/2π = 180/π degrees
		ctx.arc(this.x, this.y, this.radius, 0, Math.PI*2, false);
		// Close Drawing Path
		ctx.closePath();
		// Fill the canvas with the arc
		ctx.fill();
	},

	// These are just some helpers that
	// I've created, got no use in this
	// creation. These might give you some idea
	// to do some funky things .. Who knows ? :)
	trackPosition: function() {
		var position = {x: this.x, y: this.y};

		this._position.x = this.x;
		this._position.y = this.y;
	},
	getPosition: function() {
		return this._position;
	}
};

function createCollisionParticles() {
    // Create a particle object and use `Particle`
    // as the prototype of the object. I hope you know
    // about prototypes right ? Prototypal Inheritance, nope ? :S
    var leftParticle = Object.create(Particle);
    var rightParticle = Object.create(Particle);

    // Random number between -5 and 5 using
    // our utility function, that was defined above.
    leftParticle.x_speed = 1;
    leftParticle.y_speed = 0
    rightParticle.x_speed = -1;
    rightParticle.y_speed = 0;

    // Set positions
    leftParticle.x = 0;
    leftParticle.y = window_height / 2;

    rightParticle.x = window_width;
    rightParticle.y = window_height / 2;

    // Set the new particle's background color
    // HSLA FTW!
    // In the previous experiment, we were setting
    // the color inside the for loop below. Due to that
    // the particles used to change colors during emission.
    // This time, we'll set it beforehand, so that it doesnt
    // do that :)
    leftParticle.bg_color = "hsla("+$$.randomInt(0, 360)+", 80%, 50%, 0.5)";

    // Push the newly created leftParticle
    // into our master array
    particles.push(leftParticle);
    particles.push(rightParticle);

    //console.log('Particle created');
}

function createParticle() {
	// Create a particle object and use `Particle`
	// as the prototype of the object. I hope you know
	// about prototypes right ? Prototypal Inheritance, nope ? :S
	var particle = Object.create(Particle);

	// Random number between -5 and 5 using
	// our utility function, that was defined above.
	particle.x_speed = $$.randomInt(-3, 3);
	particle.y_speed = $$.randomInt(-3, 3);

	if(particle.x_speed == 0) {
		particle.x_speed = 1;
	}

	if(particle.y_speed == 0) {
		particle.y_speed = 1;
	}

	// Set the new particle's background color
	// HSLA FTW!
	// In the previous experiment, we were setting
	// the color inside the for loop below. Due to that
	// the particles used to change colors during emission.
	// This time, we'll set it beforehand, so that it doesnt
	// do that :)
	particle.bg_color = "hsla("+$$.randomInt(0, 360)+", 80%, 50%, 0.5)";

	// Push the newly created particle
	// into our master array
	particles.push(particle);

    //console.log('Particle created');
}

function collisionRepaint() {
    // Clear the entire Canvas
    // ctx.clearRect(0, 0, window_width, window_height);
    //
    // This is what leads to trails :)
    // You repaint the background with lesser opacity
    // which causes the particles from previous frame
    // to show up. It keeps on repeating unless the background
    // for the oldest particle becomes opaque and finally
    // that particle ceases to exist.

    ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
    ctx.fillRect(0, 0, window_width, window_height);

    var leftParticle = particles[0];
    var rightParticle = particles[1];

    leftParticle.draw();
    rightParticle.draw();

    leftParticle.x = leftParticle.x + (leftParticle.x_speed * 2);
    rightParticle.x = rightParticle.x + (rightParticle.x_speed *2);

    if(leftParticle.x >= rightParticle.x) {
        clearInterval(collisionTimer);
		collided = true;
		particles.splice(0, 2);
        particles.length = 0;
    }

    leftParticle.trackPosition();
    rightParticle.trackPosition();
}

function repaint() {
	// Clear the entire Canvas
	// ctx.clearRect(0, 0, window_width, window_height);
	//
	// This is what leads to trails :)
	// You repaint the background with lesser opacity
	// which causes the particles from previous frame
	// to show up. It keeps on repeating unless the background
	// for the oldest particle becomes opaque and finally
	// that particle ceases to exist.
	ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
	ctx.fillRect(0, 0, window_width, window_height);

	// Re-draw all particles we have in our bag!
	for (var i = 0; i < particles.length; i++) {
		var particle = particles[i];
		particle.draw();

		// In the previous experiment, we restricted
		// particles count to 500. This time we'll do
		// something cooler! We'll simply get rid of
		// the particles that go out of our view port from the
		// master array.
		//
		// Settles at somewhere below 150 particles :)
		if (particle.x > window_width || particle.x < 0
			 || particle.y > window_height || particle.y < 0) {
			particles.splice(i, 1);
		}

		// Changing x and y co-ordinates which
		// are random (generated in createParticle())
		//
		// This is cool, as we get different
		// speed for each particles then!
		//
		// Get rid of the *5 for yet another cool
		// trailing effect. Might also wanna adjust the speed
		// then by changing the $$.randomInt arguments above
		// in createParticle()
		particle.x = particle.x + (particle.x_speed*2);
		particle.y = particle.y + (particle.y_speed*2);

		// Track new position
		// Just a helper that might give you some
		// cool ideas to make some unique twists to this
		// experiment.
		particle.trackPosition();
	}
}

var time = 0;
masterTimer = setInterval(function() {

	timeout = false;

	if(collided) {
		time = time + 1;
	}

	if(time > 2) {
		timeout = true;
		clearInterval(masterTimer);
	}

}, 1000);

function particleCollision() {

    collided = false;

    createCollisionParticles();

    collisionTimer = setInterval(collisionRepaint, 2000/60);
}

//Collide two particles
particleCollision();

// Magic method for animation!
jets = setInterval(function() {

	//console.log("collided = " + collided);
	//console.log("timeout = " + timeout);

    if(collided == true) {
		if(timeout == false) {
			//console.log("creating particle");
			createParticle();
		}

		if(particles.length > 0) {
			//console.log("# particles = " + particles.length);
			repaint();
		} else {
			console.log("All done...");
			ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
			ctx.fillRect(0, 0, window_width, window_height);
			ctx.clearRect(0, 0, window_width, window_height);
			collided = false;
			timeout = false;
			clearInterval(jets);
		}
    }

}, 2000/60);    //Was set to 1000: Increasing causes slower particle generation, decreasing causes faster generation
