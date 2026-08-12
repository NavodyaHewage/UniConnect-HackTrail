<?php

// Entry point for plain htdocs installs where this folder is served as
// http://localhost/UniConnect-HackTrail/ (no vhost pointing at public/).
// Sends the browser into the real front controller.
header('Location: public/');
